<div class="documentation-layout">
    <?php require __DIR__ . '/_nav.php'; ?>
    <article class="documentation-content">
<h1>Features</h1>
<p>A quick overview of what Sparkframe provides. Each feature has a dedicated guide with usage examples.</p>
<h2>Bootstrap</h2>
<ul><li>Singleton bootstrapper with ordered initialization steps</li><li>Load <code>.env</code> configuration from the project root</li><li>Register database connections and discover controllers</li><li>Optional PHP session start</li></ul>
<p>→ <a href="/documentation/application-structure">Application structure</a> · <a href="/documentation/configuration">Configuration</a></p>
<h2>Routing</h2>
<ul><li>Define routes with PHP <code>#[Route]</code> attributes on controller methods</li><li>HTTP method enum: GET, POST, PUT, PATCH, DELETE</li><li>Typed URL parameters (<code>{:int}</code>, <code>{:str}</code>, <code>*</code>)</li><li>Multiple routes on a single controller method</li></ul>
<p>→ <a href="/documentation/routing">Routing</a></p>
<h2>MVC</h2>
<ul><li><strong>Controllers</strong> — auto-discovered from <code>src/Controller/</code>; handle requests and return responses</li><li><strong>Models</strong> — thin layer over the query builder, tied to an entity class and table name</li><li><strong>Views</strong> — plain PHP files in <code>src/View/</code>; data passed via <code>render()</code></li></ul>
<p>→ <a href="/documentation/controllers">Controllers</a> · <a href="/documentation/models-and-query-builder">Models and query builder</a> · <a href="/documentation/views">Views</a></p>
<h2>Data layer</h2>
<ul><li><strong>Entities</strong> — PHP classes mapped to tables via <code>#[Column]</code> and <code>#[Primary]</code> attributes</li><li><strong>Query builder</strong> — fluent SELECT, INSERT, UPDATE, and DELETE builders</li><li><strong>Subqueries</strong> — use a select query as a value in <code>whereIn</code> / <code>orIn</code></li><li><strong>Transactions</strong> — insert and delete operations run inside transactions</li><li><strong>Multi-database</strong> — MySQL and SQLite; switch per model</li></ul>
<p>→ <a href="/documentation/entities">Entities</a> · <a href="/documentation/models-and-query-builder">Models and query builder</a> · <a href="/documentation/configuration">Configuration</a></p>
<h2>HTTP</h2>
<ul><li><strong>Request wrapper</strong> — access URI, HTTP method, <code>$_POST</code>, and raw request body</li><li><strong>Redirects</strong> — <code>redirect()</code> helper sends a <code>Location</code> header and stops execution</li></ul>
<p>→ <a href="/documentation/requests-and-sessions">Requests and sessions</a> · <a href="/documentation/controllers">Controllers</a></p>
<h2>Configuration</h2>
<ul><li>Environment variables via <code>.env</code> and <a href="https://github.com/vlucas/phpdotenv">vlucas/phpdotenv</a></li><li>Named database connections in a <code>DatabaseInfoCollection</code></li></ul>
<p>→ <a href="/documentation/configuration">Configuration</a></p>
<h2>Sessions</h2>
<ul><li><code>getFromSession($key)</code> and <code>setInSession($key, $value)</code> global helpers</li><li>Session started via <code>Bootstrapper::startSession()</code> in your bootstrap</li></ul>
<p>→ <a href="/documentation/requests-and-sessions">Requests and sessions</a></p>
<nav class="documentation-pager" aria-label="Page navigation">
    <a href="/documentation/introduction" role="button" class="secondary">Previous</a>
    <span class="documentation-pager__topic documentation-pager__topic--prev">Introduction</span>
    <span class="documentation-pager__topic documentation-pager__topic--next">Application structure</span>
    <a href="/documentation/application-structure" role="button">Next</a>
</nav>
    </article>
</div>
