<div class="documentation-layout">
    <?php require __DIR__ . '/_nav.php'; ?>
    <article class="documentation-content">
<h1>Introduction</h1>
<h2>What is Sparkframe?</h2>
<p>Sparkframe (<code>floriansdv/sparkframe</code>) is a lightweight PHP library for personal projects. It gives you a structured way to build web applications without the complexity of a full-stack framework.</p>
<p>You install it as a Composer dependency and extend its base classes in your own <code>App\</code> namespace. Sparkframe Firestarter (this repository) is a working example you can copy to get started quickly.</p>
<p>I build Sparkframe as a personal challenge. I started this project for the following reasons:</p>
<ul><li>for fun</li><li>to learn more about PHP features that I don&#039;t use daily</li><li>learn more about composer </li><li>I wanted to finish something</li></ul>
<p><strong>Requirements:</strong> PHP 8.4 or higher, with the PDO extension.</p>
<h2>Core concepts</h2>
<p>Sparkframe is built around three pillars:</p>
<ol><li><strong>Routing</strong> — define URLs with PHP attributes (<code>#[Route]</code>) on controller methods. No separate route configuration file.</li><li><strong>MVC</strong> — separate controllers (request handling), models (data access), and views (HTML templates).</li><li><strong>Query builder</strong> — build type-safe SQL through a fluent API. Results are automatically mapped to entity objects.</li></ol>
<h2>Additional capabilities</h2>
<p>Beyond routing, MVC, and the query builder, Sparkframe also provides:</p>
<ul><li><strong>Multi-database support</strong> — MySQL and SQLite through a single abstraction layer</li><li><strong>Configuration</strong> — environment variables loaded from a <code>.env</code> file</li><li><strong>Session helpers</strong> — simple functions to read and write session data</li><li><strong>Front controller</strong> — all HTTP requests go through <code>public/index.php</code></li></ul>
<p>See <a href="/documentation/features">Features</a> for the full list.</p>
<h2>What Sparkframe is not</h2>
<p>Sparkframe is intentionally minimal. It does <strong>not</strong> include:</p>
<ul><li>Authentication or authorization</li><li>Middleware or a request pipeline</li><li>A dependency injection container</li><li>Database migrations</li><li>Form validation</li><li>Built-in caching or logging</li></ul>
<p>You can add these yourself or keep your application simple. Knowing these limits upfront helps you decide whether Sparkframe fits your project.</p>
<h2>How your application uses Sparkframe</h2>
<p>Your app lives alongside the framework:</p>
<pre><code>your-app/
  public/index.php          ← entry point
  src/
    Bootstrap/              ← your bootstrapper and database config
    Controller/             ← your controllers (auto-discovered)
    Entity/                 ← your entities
    Model/                  ← your models
    View/                   ← your PHP templates
  vendor/floriansdv/sparkframe/  ← the framework (Composer)</code></pre>
<p>You extend framework classes (<code>Controller</code>, <code>Entity</code>, <code>Model</code>, <code>BaseBootstrapper</code>) and wire everything together in <code>appstart.php</code>. The framework handles routing and database access; you write the application logic.</p>
<h2>Request lifecycle</h2>
<p>Every HTTP request follows the same path:</p>
<pre class="mermaid">sequenceDiagram
    participant Browser
    participant IndexPHP as public/index.php
    participant AppStart as appstart.php
    participant Bootstrapper
    participant RequestHandler
    participant Controller

    Browser->>IndexPHP: HTTP request
    IndexPHP->>AppStart: require
    AppStart->>Bootstrapper: initializeGlobals, bootstrap, startSession
    AppStart->>RequestHandler: handle
    RequestHandler->>Controller: matched route method
    Controller-->>Browser: HTML, JSON, or redirect</pre>
<ol><li>The web server sends the request to <code>public/index.php</code>.</li><li><code>appstart.php</code> loads Composer, initializes configuration, connects to databases, and discovers controllers.</li><li><code>RequestHandler</code> matches the URL and HTTP method to a controller method.</li><li>The controller method runs and returns a response (HTML page, JSON, or redirect).</li></ol>
<p>For details on wiring the bootstrap, see <a href="/documentation/application-structure">Application structure</a>.</p>
<h2>Next steps</h2>
<ul><li><a href="/documentation/features">Features</a> — see everything Sparkframe offers at a glance</li><li><a href="/documentation/application-structure">Application structure</a> — understand the project layout</li><li><a href="/documentation/routing">Routing</a> — define your first route</li></ul>
    </article>
</div>
