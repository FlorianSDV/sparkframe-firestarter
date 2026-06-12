<div class="documentation-layout">
    <?php require __DIR__ . '/_nav.php'; ?>
    <article class="documentation-content">
<h1>Requests and sessions</h1>
<p>This page covers reading HTTP input, sending redirects, using sessions, and building JSON APIs.</p>
<h2>The Request object</h2>
<p>Every controller has access to <code>$this-&gt;request</code>, an instance of <code>Sparkframe\Request\Request</code>.</p>
<table><thead><tr><th>Method</th><th>Returns</th><th>Source</th></tr></thead><tbody><tr><td><code>getUri()</code></td><td>Request URI string</td><td><code>$_SERVER[&#039;REQUEST_URI&#039;]</code></td></tr><tr><td><code>getRequestMethod()</code></td><td>HTTP method string</td><td><code>$_SERVER[&#039;REQUEST_METHOD&#039;]</code></td></tr><tr><td><code>getRequestPost()</code></td><td>Associative array</td><td><code>$_POST</code></td></tr><tr><td><code>getRequestBody()</code></td><td>Raw body string</td><td><code>php://input</code></td></tr></tbody></table>
<h2>HTML form data (POST)</h2>
<p>For standard HTML forms with <code>method=&quot;post&quot;</code> and <code>application/x-www-form-urlencoded</code> or <code>multipart/form-data</code>:</p>
<pre><code class="language-php">#[Route('/notes/create', RequestMethod::POST)]
public function createNote(): void
{
    $post = $this-&gt;request-&gt;getRequestPost();
    $note = $this-&gt;notesModel-&gt;createNote($post);
    $this-&gt;redirect('/notes/get/' . $note-&gt;id);
}</code></pre>
<p>Access fields by name:</p>
<pre><code class="language-php">$text = $post['text'];
$id = (int) $post['id'];</code></pre>
<p>Validate and sanitize input in your controller or model — you decide what rules apply.</p>
<h2>JSON request body (API)</h2>
<p>For APIs that send JSON in the request body, read the raw body and decode it:</p>
<pre><code class="language-php">#[Route('/api/notes/create', RequestMethod::POST)]
public function createNote(): void
{
    $body = json_decode($this-&gt;request-&gt;getRequestBody(), true);
    $note = $this-&gt;notesModel-&gt;createNote($body);
    echo json_encode(['status' =&gt; 'Success!', 'note' =&gt; $note]);
}</code></pre>
<p>Use <code>getRequestBody()</code> for POST, PATCH, PUT, and DELETE requests with a JSON body. Use <code>getRequestPost()</code> for HTML forms.</p>
<h2>Redirects</h2>
<pre><code class="language-php">$this-&gt;redirect('/notes');</code></pre>
<p><code>redirect()</code> is defined on <code>Sparkframe\Controller\Controller</code>. It:</p>
<ol><li>Sends a <code>Location</code> header with the given path</li><li>Calls <code>exit</code> — no code after it runs</li></ol>
<p>Use redirects after successful POST requests to implement the post/redirect/get pattern.</p>
<h2>Sessions</h2>
<h3>Start a session</h3>
<p>Call <code>startSession()</code> in your bootstrap (firestarter does this in <code>appstart.php</code>):</p>
<pre><code class="language-php">$bootstrapper-&gt;startSession();</code></pre>
<p>Omit this if your application does not use sessions.</p>
<h3>Read and write session data</h3>
<p>Sparkframe provides two global helper functions (loaded automatically by Composer):</p>
<pre><code class="language-php">setInSession('user_id', 42);
$userId = getFromSession('user_id');</code></pre>
<p>These wrap <code>$_SESSION</code> directly. Build flash messages or expiration logic in your own code when you need them.</p>
<h2>JSON API responses</h2>
<p>Return JSON with <code>echo json_encode(...)</code>:</p>
<pre><code class="language-php">#[Route('/api/notes', RequestMethod::GET)]
public function getAllNotes(): void
{
    $notes = $this-&gt;notesModel-&gt;getAllNotes();
    echo json_encode($notes);
}</code></pre>
<p>Set headers if your API requires them:</p>
<pre><code class="language-php">header('Content-Type: application/json');
echo json_encode($data);</code></pre>
<p>See <code>NotesApiController</code> in firestarter for a complete REST example with GET, POST, PATCH, and DELETE.</p>
<h2>Error handling</h2>
<p>Firestarter&#039;s <code>appstart.php</code> catches exceptions and dumps them with <code>var_dump</code>. This is fine for development but not for production:</p>
<pre><code class="language-php">} catch (\Exception $e) {
    // Replace with your own error handling for production.
    echo "&lt;pre&gt;";
    var_dump($e);
    echo "&lt;/pre&gt;";
}</code></pre>
<p>Customize these catch blocks to log errors and show a generic error page.</p>
<nav class="documentation-pager" aria-label="Page navigation">
    <a href="/documentation/views" role="button" class="secondary">Previous</a>
    <span class="documentation-pager__topic documentation-pager__topic--prev">Views</span>
    <span class="documentation-pager__spacer" aria-hidden="true"></span>
    <span class="documentation-pager__spacer" aria-hidden="true"></span>
</nav>
    </article>
</div>
