<div class="documentation-layout">
    <?php require __DIR__ . '/_nav.php'; ?>
    <article class="documentation-content">
<h1>Views</h1>
<p>Views are plain PHP files that render HTML. Sparkframe has no template engine — you write standard PHP with optional HTML.</p>
<h2>Location and naming</h2>
<p>Views live in <code>src/View/</code>. The path you pass to <code>render()</code> maps directly to a file:</p>
<table><thead><tr><th><code>render()</code> argument</th><th>File path</th></tr></thead><tbody><tr><td><code>&#039;index&#039;</code></td><td><code>src/View/index.php</code></td></tr><tr><td><code>&#039;notes/index&#039;</code></td><td><code>src/View/notes/index.php</code></td></tr><tr><td><code>&#039;partials/header&#039;</code></td><td><code>src/View/partials/header.php</code></td></tr></tbody></table>
<h2>Render a view from a controller</h2>
<pre><code class="language-php">$this-&gt;render('notes/index', ['notes' =&gt; $notes]);</code></pre>
<p>The second argument is an associative array. Keys become variables in the view via <code>extract()</code>. In the example above, <code>$notes</code> is available inside <code>notes/index.php</code>.</p>
<h2>View file example</h2>
<pre><code class="language-php">&lt;?php

declare(strict_types=1);

/** @var list&lt;\App\Entity\NoteEntity&gt; $notes */

?&gt;
&lt;h1&gt;Notes&lt;/h1&gt;

&lt;?php if (count($notes) === 0): ?&gt;
    &lt;p&gt;No notes yet.&lt;/p&gt;
&lt;?php else: ?&gt;
    &lt;ul&gt;
        &lt;?php foreach ($notes as $note): ?&gt;
            &lt;li&gt;
                &lt;a href="/notes/get/&lt;?= $note-&gt;id; ?&gt;"&gt;
                    &lt;?= htmlspecialchars($note-&gt;text, ENT_QUOTES, 'UTF-8'); ?&gt;
                &lt;/a&gt;
            &lt;/li&gt;
        &lt;?php endforeach; ?&gt;
    &lt;/ul&gt;
&lt;?php endif; ?&gt;</code></pre>
<p>Add PHPDoc <code>@var</code> annotations to document which variables the view expects. This helps your IDE and future readers.</p>
<h2>Partials and layout</h2>
<p>Sparkframe does not include a layout system. You compose pages by calling <code>render()</code> multiple times.</p>
<p>Firestarter uses <code>BaseController::renderPage()</code> to wrap every page with a header and footer:</p>
<pre><code class="language-php">$this-&gt;render('partials/header', $layoutData);
$this-&gt;render($viewName, $data);
$this-&gt;render('partials/footer', $layoutData);</code></pre>
<p>Create your own layout helper if you want consistent navigation, titles, or styles across pages.</p>
<h2>Escaping user output</h2>
<p>Always escape data that comes from users or the database before outputting it in HTML:</p>
<pre><code class="language-php">&lt;?= htmlspecialchars($note-&gt;text, ENT_QUOTES, 'UTF-8'); ?&gt;</code></pre>
<p>Without escaping, user input can lead to XSS vulnerabilities. Numeric IDs in URLs are generally safe, but text content is not.</p>
<h2>Styling</h2>
<p>Sparkframe does not include CSS or a design system. Firestarter uses <a href="https://picocss.com/">Pico CSS</a> via a CDN link in <code>partials/header.php</code> plus a custom <code>public/css/app.css</code>.</p>
<p>Static assets go in <code>public/</code> and are served directly by the web server (they bypass the front controller).</p>
<h2>Forms</h2>
<p>HTML forms POST to routes defined on your controllers:</p>
<pre><code class="language-xml">&lt;form method="post" action="/notes/create"&gt;
    &lt;textarea name="text" required&gt;&lt;/textarea&gt;
    &lt;button type="submit"&gt;Create&lt;/button&gt;
&lt;/form&gt;</code></pre>
<p>Read submitted values in the controller:</p>
<pre><code class="language-php">$post = $this-&gt;request-&gt;getRequestPost();
$note = $this-&gt;notesModel-&gt;createNote($post);</code></pre>
<p>Sparkframe does not include CSRF protection. Add tokens yourself if your application needs them.</p>
<nav class="documentation-pager" aria-label="Page navigation">
    <a href="/documentation/models-and-query-builder" role="button" class="secondary">Previous</a>
    <span class="documentation-pager__topic documentation-pager__topic--prev">Models and query builder</span>
    <span class="documentation-pager__topic documentation-pager__topic--next">Requests and sessions</span>
    <a href="/documentation/requests-and-sessions" role="button">Next</a>
</nav>
    </article>
</div>
