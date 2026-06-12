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
<table><thead><tr><th>Directory</th><th>Purpose</th></tr></thead><tbody><tr><td><code>public/</code></td><td>Web root. Only files here are directly accessible by the browser.</td></tr><tr><td><code>src/Bootstrap/</code></td><td>Startup logic: load config, connect databases, start session.</td></tr><tr><td><code>src/Controller/</code></td><td>One class per resource or area; each handles HTTP requests.</td></tr><tr><td><code>src/Entity/</code></td><td>Classes that map to database tables.</td></tr><tr><td><code>src/Model/</code></td><td>Data access layer using the query builder.</td></tr><tr><td><code>src/View/</code></td><td>PHP templates rendered by controllers.</td></tr></tbody></table>
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

    $bootstrapper-&gt;initializeGlobals($root_dir);
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
<ol><li><strong><code>initializeGlobals($root_dir)</code></strong> — stores the project root and loads variables from <code>.env</code> into <code>$_ENV</code>.</li><li><strong><code>new DatabaseInfoCollection()</code></strong> — your class that registers named database connections (see <a href="/documentation/configuration">Configuration</a>).</li><li><strong><code>bootstrap($database_info_collection)</code></strong> — connects to databases, scans <code>src/Controller/</code> for controllers, and registers all routes.</li><li><strong><code>startSession()</code></strong> — starts a PHP session (optional; omit if you do not need sessions).</li><li><strong><code>RequestHandler::handle()</code></strong> — matches the current request to a route and calls the controller method.</li></ol>
<p>Each bootstrap step runs only once, even if called multiple times.</p>
<h2>Controller auto-discovery</h2>
<p>You do not register controllers manually. The framework scans <code>src/Controller/</code> and instantiates every class that:</p>
<ul><li>lives in the <code>App\Controller\</code> namespace</li><li>extends <code>Sparkframe\Controller\Controller</code></li><li>is not named <code>BaseController</code></li></ul>
<p>Add a new controller file and it is picked up on the next request. See <a href="/documentation/controllers">Controllers</a> for how to create one.</p>
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
<h2>Next steps</h2>
<ul><li><a href="/documentation/configuration">Configuration</a> — set up <code>.env</code> and database connections</li><li><a href="/documentation/routing">Routing</a> — define your first routes</li><li><a href="/documentation/controllers">Controllers</a> — create a controller</li></ul>
    </article>
</div>
