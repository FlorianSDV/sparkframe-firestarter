<div class="documentation-layout">
    <?php require __DIR__ . '/_nav.php'; ?>
    <article class="documentation-content">
        <h1>Application structure</h1>
        <p>This page describes how a Sparkframe application is organized and how it starts up.</p>
        <h2>Directory layout</h2>
        <p>A typical project looks like this:</p>
        <pre><code class="language-plaintext">your-app/
├── public/
│   ├── index.php          # Front controller — only web entry point
│   ├── .htaccess          # Apache rewrite rules (optional)
│   └── css/               # Static assets
├── src/
│   ├── Bootstrap/
│   │   ├── appstart.php   # Application bootstrap and request handling
│   │   ├── Bootstrapper.php
│   │   └── DatabaseInfoCollection.php
│   ├── Controller/        # Controllers (auto-discovered)
│   ├── Entity/            # Entity classes
│   ├── Model/             # Model classes
│   └── View/              # PHP view templates
├── vendor/                # Composer dependencies (includes Sparkframe)
├── .env                   # Environment configuration (not committed)
└── composer.json</code></pre>
        <table>
            <thead>
                <tr>
                    <th>Directory</th>
                    <th>Purpose</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>public/</code></td>
                    <td>Web root. Only files here are directly accessible by the browser.</td>
                </tr>
                <tr>
                    <td><code>src/Bootstrap/</code></td>
                    <td>Startup logic: load config, connect databases, start session.</td>
                </tr>
                <tr>
                    <td><code>src/Controller/</code></td>
                    <td>One class per resource or area; each handles HTTP requests.</td>
                </tr>
                <tr>
                    <td><code>src/Entity/</code></td>
                    <td>Classes that map to database tables.</td>
                </tr>
                <tr>
                    <td><code>src/Model/</code></td>
                    <td>Data access layer using the query builder.</td>
                </tr>
                <tr>
                    <td><code>src/View/</code></td>
                    <td>PHP templates rendered by controllers.</td>
                </tr>
            </tbody>
        </table>
        <h2>Entry point</h2>
        <p>All requests go through a single file:</p>
        <pre><code class="language-php">// public/index.php
&lt;?php

declare(strict_types=1);

require_once __DIR__ . '/../src/Bootstrap/appstart.php';</code></pre>
        <p><code>appstart.php</code> loads Composer, runs the bootstrap, and dispatches the request.</p>
        <h2>Bootstrap flow</h2>
        <p>Your <code>appstart.php</code> wires the framework together. Firestarter uses this pattern:</p>
        <pre><code class="language-php">&lt;?php

declare(strict_types=1);

namespace App\Bootstrap;

use Sparkframe\Request\RequestHandler;

require __DIR__ . '/../../vendor/autoload.php';

try {
    $root_dir = dirname(__DIR__, 2);
    $bootstrapper = Bootstrapper::getInstance();

    $controllers_dir = $root_dir . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Controller';
    $view_dir = $root_dir . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'View';

    $bootstrapper-&gt;initializeGlobals($root_dir, $controllers_dir, $view_dir);
    $database_info_collection = new DatabaseInfoCollection();
    $bootstrapper-&gt;bootstrap($database_info_collection);

    $bootstrapper-&gt;startSession();

    $requestHandler = new RequestHandler();
    $requestHandler-&gt;handle();
} catch (\Exception $e) {
    // Replace with your own error handling for production.
    echo "&lt;pre&gt;";
    var_dump($e);
    echo "&lt;/pre&gt;";
}</code></pre>
        <h3>Step by step</h3>
        <ol>
            <li><strong><code>initializeGlobals($root_dir, $controllers_dir, $view_dir)</code></strong> — stores the project root, controller directory, and view directory; loads variables from <code>.env</code> into <code>$_ENV</code>.</li>
            <li><strong><code>new DatabaseInfoCollection()</code></strong> — your class that registers named database connections (see <a href="/documentation/configuration">Configuration</a>).</li>
            <li><strong><code>bootstrap($database_info_collection)</code></strong> — connects to databases, scans the controller directory for controllers, and registers all routes.</li>
            <li><strong><code>startSession()</code></strong> — starts a PHP session (optional; omit if you do not need sessions).</li>
            <li><strong><code>RequestHandler::handle()</code></strong> — matches the current request to a route and calls the controller method.</li>
        </ol>
        <p>Each bootstrap step runs only once, even if called multiple times.</p>
        <h2>Custom controller directory</h2>
        <p>The second argument to <code>initializeGlobals()</code> sets which directory the framework scans for controller files. Firestarter uses <code>src/Controller/</code>, but you can point to any directory:</p>
        <pre><code class="language-php">$controllers_dir = $root_dir . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Http' . DIRECTORY_SEPARATOR . 'Controllers';
$bootstrapper-&gt;initializeGlobals($root_dir, $controllers_dir, $view_dir);</code></pre>
        <p>During <code>bootstrap()</code>, the framework runs <code>glob($controllers_dir . '/*.php')</code> and instantiates each class it finds.</p>
        <p>Keep these constraints in mind when using a custom path:</p>
        <ul>
            <li>Controller classes must still use the <code>App\Controller\</code> namespace</li>
            <li>Each class must extend <code>Sparkframe\Controller\Controller</code></li>
            <li>Abstract classes (such as <code>BaseController</code>) are skipped</li>
            <li>Your Composer PSR-4 autoload must resolve the namespace to the correct directory — Firestarter maps <code>App\</code> to <code>src/</code>, so controllers must live somewhere under <code>src/</code></li>
        </ul>
        <h2>Controller auto-discovery</h2>
        <p>You do not register controllers manually. The framework scans the configured controller directory and instantiates every class that:</p>
        <ul>
            <li>lives in the <code>App\Controller\</code> namespace</li>
            <li>extends <code>Sparkframe\Controller\Controller</code></li>
            <li>is not <code>abstract</code></li>
        </ul>
        <p>Add a new controller file and it is picked up on the next request. See <a href="/documentation/controllers">Controllers</a> for how to create one.</p>
        <h2>Custom view directory</h2>
        <p>The third argument to <code>initializeGlobals()</code> sets the base directory for view files. It is optional (<code>?string $view_dir = null</code>). Firestarter uses <code>src/View/</code>, but you can point to any directory:</p>
        <pre><code class="language-php">$view_dir = $root_dir . DIRECTORY_SEPARATOR . 'templates';
$bootstrapper-&gt;initializeGlobals($root_dir, $controllers_dir, $view_dir);</code></pre>
        <p>When a controller calls <code>$this-&gt;render('notes/index', $data)</code>, the framework resolves the file as <code>$view_dir/notes/index.php</code>. The argument to <code>render()</code> is always a relative view name — never an absolute path.</p>
        <p>See <a href="/documentation/views">Views</a> for naming conventions and examples.</p>
        <h2>Apache rewrite</h2>
        <p>If you use Apache, <code>public/.htaccess</code> sends all non-file requests to the front controller:</p>
        <pre><code class="language-apache">RewriteEngine On

RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^ index.php [QSA,L]</code></pre>
        <p>With PHP&#039;s built-in server, use:</p>
        <pre><code class="language-bash">php -S localhost:8000 -t public/</code></pre>
        <h2>Your bootstrap classes</h2>
        <p>You extend two framework classes in <code>src/Bootstrap/</code>:</p>
        <p><strong><code>Bootstrapper</code></strong> — extends <code>Sparkframe\Bootstrap\BaseBootstrapper</code>. Firestarter leaves it empty; add custom initialization here if needed.</p>
        <p><strong><code>DatabaseInfoCollection</code></strong> — extends <code>Sparkframe\Database\BaseDatabaseInfoCollection</code>. Maps named databases to connection details from <code>.env</code>. See <a href="/documentation/configuration">Configuration</a>.</p>
        <nav class="documentation-pager" aria-label="Page navigation">
            <a href="/documentation/features" role="button" class="secondary">Previous</a>
            <span class="documentation-pager__topic documentation-pager__topic--prev">Features</span>
            <span class="documentation-pager__topic documentation-pager__topic--next">Configuration</span>
            <a href="/documentation/configuration" role="button">Next</a>
        </nav>
    </article>
</div>