<div class="documentation-layout">
    <?php require __DIR__ . '/_nav.php'; ?>
    <article class="documentation-content">
<h1>Controllers</h1>
<p>Controllers handle HTTP requests. They read input, call models, and return responses (HTML, JSON, or redirects).</p>
<h2>Base class</h2>
<p>Extend <code>Sparkframe\Controller\Controller</code>:</p>
<pre><code class="language-php">&lt;?php

declare(strict_types=1);

namespace App\Controller;

use Sparkframe\Controller\Controller;

class MyController extends Controller
{
    // Your route methods here
}</code></pre>
<p>Every controller automatically receives a <code>Request</code> instance as <code>$this-&gt;request</code>.</p>
<h2>Available methods</h2>
<table><thead><tr><th>Method</th><th>Description</th></tr></thead><tbody><tr><td><code>$this-&gt;request</code></td><td>Current HTTP request (see <a href="/documentation/requests-and-sessions">Requests and sessions</a>)</td></tr><tr><td><code>$this-&gt;render($view, $data)</code></td><td>Render a PHP view from <code>src/View/</code></td></tr><tr><td><code>$this-&gt;redirect($location)</code></td><td>Send HTTP redirect and stop execution</td></tr></tbody></table>
<p><code>redirect()</code> is <code>protected</code>; call it from within your controller.</p>
<h2>Create a new controller</h2>
<h3>Step 1 — Create the file</h3>
<p>Create <code>src/Controller/TagsController.php</code> in the <code>App\Controller</code> namespace:</p>
<pre><code class="language-php">&lt;?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\TagsModel;
use Sparkframe\Attributes\Route;
use Sparkframe\Controller\Controller;
use Sparkframe\Tools\RequestMethod;

class TagsController extends Controller
{
    private TagsModel $tagsModel;

    public function __construct()
    {
        $this-&gt;tagsModel = new TagsModel();
        parent::__construct();
    }

    #[Route('/tags', RequestMethod::GET)]
    public function index(): void
    {
        $tags = $this-&gt;tagsModel-&gt;getAll();
        $this-&gt;render('tags/index', ['tags' =&gt; $tags]);
    }
}</code></pre>
<h3>Step 2 — Call <code>parent::__construct()</code></h3>
<p>If you override the constructor (for example to inject a model), always call <code>parent::__construct()</code> so <code>$this-&gt;request</code> is initialized.</p>
<h3>Step 3 — Add routes</h3>
<p>Annotate public methods with <code>#[Route]</code>. See <a href="/documentation/routing">Routing</a>.</p>
<h3>Step 4 — No registration needed</h3>
<p>Save the file. The framework discovers it on the next request.</p>
<h2>HTML controller pattern</h2>
<p>Firestarter&#039;s <code>NotesController</code> follows a typical CRUD pattern:</p>
<pre><code class="language-php">#[Route('/notes', RequestMethod::GET)]
public function getAllNotes(): void
{
    $notes = $this-&gt;notesModel-&gt;getAllNotes();
    $this-&gt;renderPage('notes/index', ['notes' =&gt; $notes], 'Notes', 'notes');
}

#[Route('/notes/create', RequestMethod::POST)]
public function createNote(): void
{
    $post = $this-&gt;request-&gt;getRequestPost();
    $note = $this-&gt;notesModel-&gt;createNote($post);
    $this-&gt;redirect('/notes/get/' . $note-&gt;id);
}</code></pre>
<p>Common patterns:</p>
<ul><li><strong>GET</strong> — fetch data from the model, render a view</li><li><strong>POST</strong> — read form data, mutate via the model, redirect to avoid duplicate submissions</li></ul>
<h2>Layout wrapper (app convention)</h2>
<p><code>BaseController::renderPage()</code> is a Firestarter convention that renders a header, the main view, and a footer in one call:</p>
<pre><code class="language-php">protected function renderPage(
    string $viewName,
    array $data = [],
    string $title = 'Sparkframe Firestarter',
    string $activeNav = ''
): void
{
    $layoutData = array_merge($data, ['title' =&gt; $title, 'activeNav' =&gt; $activeNav]);
    $this-&gt;render('partials/header', $layoutData);
    $this-&gt;render($viewName, $data);
    $this-&gt;render('partials/footer', $layoutData);
}</code></pre>
<p>Extend <code>BaseController</code> instead of <code>Controller</code> when you want this layout. Extend <code>Controller</code> directly for APIs or pages without a shared layout.</p>
<h2>JSON API pattern</h2>
<p><code>NotesApiController</code> extends <code>Controller</code> directly and returns JSON:</p>
<pre><code class="language-php">#[Route('/api/notes', RequestMethod::GET)]
public function getAllNotes(): void
{
    $notes = $this-&gt;notesModel-&gt;getAllNotes();
    echo json_encode($notes);
}

#[Route('/api/notes/create', RequestMethod::POST)]
public function createNote(): void
{
    $request_body = json_decode($this-&gt;request-&gt;getRequestBody(), true);
    $note = $this-&gt;notesModel-&gt;createNote($request_body);
    echo json_encode(['status' =&gt; 'Success!', 'note' =&gt; $note]);
}</code></pre>
<p>Return JSON with PHP&#039;s built-in <code>json_encode()</code> and <code>json_decode()</code>. Set <code>Content-Type: application/json</code> in your response when your API consumers expect it.</p>
<h2>Redirect after mutation</h2>
<p>After creating, updating, or deleting data, redirect to a GET page:</p>
<pre><code class="language-php">$this-&gt;redirect('/notes');</code></pre>
<p><code>redirect()</code> sends a <code>Location</code> header and calls <code>exit</code>. No code after it runs.</p>
<nav class="documentation-pager" aria-label="Page navigation">
    <a href="/documentation/routing" role="button" class="secondary">Previous</a>
    <span class="documentation-pager__topic documentation-pager__topic--prev">Routing</span>
    <span class="documentation-pager__topic documentation-pager__topic--next">Entities</span>
    <a href="/documentation/entities" role="button">Next</a>
</nav>
    </article>
</div>
