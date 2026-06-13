<div class="documentation-layout">
  <?php require __DIR__ . '/_nav.php'; ?>
  <article class="documentation-content">
    <h1>Introduction</h1>
    <h2>What is Sparkframe?</h2>
    <p>Sparkframe (<code>floriansdv/sparkframe</code>) is a lightweight PHP library for personal projects. It gives you a structured way to build web applications without the complexity of a full-stack framework.</p>
    <p>You install it as a Composer dependency and extend its base classes in your own <code>App\</code> namespace. Sparkframe Firestarter (this repository) is a working example you can copy to get started quickly.</p>
    <p>I made Sparkframe for the following reasons:</p>
    <ul>
      <li>For fun</li>
      <li>To learn more about PHP's features</li>
      <li>Learn more about composer </li>
      <li>To finish something</li>
    </ul>
    <hr>
    <p><strong>Requirements:</strong> PHP 8.4 or higher, with the PDO extension.</p>
    <h2>Core concepts</h2>
    <p>Sparkframe is built around three pillars:</p>
    <ol>
      <li><strong>Routing</strong> — define URLs with PHP attributes (<code>#[Route]</code>) on controller methods. No separate route configuration file is needed!</li>
      <li><strong>MVC</strong> — separate controllers (request handling), models and entities (data access), and views (HTML templates).</li>
      <li><strong>Query builder</strong> — build type-safe SQL through a fluent API. Results are automatically mapped to entity objects. 
      Queries can be build using the query builder in the model class itself.
      If you want more control or want to build a query without having to first create an entire new ModelClass the DatabaseWrapperInterface can be used.
      <br>
      I wanted to provide query builders that are easy to use and let you write queries as code.</li>
    </ol>
    <h2>Additional capabilities</h2>
    <p>Beyond routing, MVC, and the query builder, Sparkframe also provides:</p>
    <ul>
      <li><strong>Multi-database support</strong> — MySQL and SQLite through a single abstraction layer. Switching databases at runtime is possible.</li>
      <li><strong>Configuration</strong> — environment variables loaded from a <code>.env</code> file.</li>
      <li><strong>Session helpers</strong> — simple functions to read and write session data.</li>
      <li><strong>Front controller</strong> — all HTTP requests go through <code>public/index.php</code></li>
    </ul>
    <p>See <a href="/documentation/features">Features</a> for the full list.</p>
    <h2>What Sparkframe is not</h2>
    <p>Sparkframe is intentionally minimal. It does <strong>not</strong> include:</p>
    <ul>
      <li>Authentication or authorization</li>
      <li>Middleware or a request pipeline</li>
      <li>A dependency injection container</li>
      <li>Database migrations</li>
      <li>Form validation</li>
      <li>Built-in caching or logging</li>
    </ul>
    <p>You can add these yourself or keep your application simple. Knowing these limits upfront helps you decide whether Sparkframe fits your project.</p>
    <h2>How your application uses Sparkframe</h2>
    <p>Your app lives alongside the framework:</p>
    <pre><code class="language-plaintext">your-app/
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
    <ol>
      <li>The web server sends the request to <code>public/index.php</code>.</li>
      <li><code>appstart.php</code> loads Composer, initializes configuration, connects to databases, and discovers controllers.</li>
      <li><code>RequestHandler</code> matches the URL and HTTP method to a controller method.</li>
      <li>The controller method runs and returns a response (HTML page, JSON, or redirect).</li>
    </ol>
    <p>For details on wiring the bootstrap, see <a href="/documentation/application-structure">Application structure</a>.</p>
    <nav class="documentation-pager" aria-label="Page navigation">
      <a href="/documentation/overview" role="button" class="secondary">Previous</a>
      <span class="documentation-pager__topic documentation-pager__topic--prev">Overview</span>
      <span class="documentation-pager__topic documentation-pager__topic--next">Features</span>
      <a href="/documentation/features" role="button">Next</a>
    </nav>
  </article>
</div>