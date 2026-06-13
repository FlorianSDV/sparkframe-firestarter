<div class="documentation-layout">
    <?php require __DIR__ . '/_nav.php'; ?>
    <article class="documentation-content">
        <h1>Routing</h1>
        <p>Routes map URLs and HTTP methods to controller methods. You define them with PHP attributes — no separate route configuration file is needed.</p>
        <h2>Basic route</h2>
        <p>Add a <code>#[Route]</code> attribute above a controller method:</p>
        <pre><code class="language-php">use Sparkframe\Attributes\Route;
use Sparkframe\Tools\RequestMethod;

#[Route('/notes', RequestMethod::GET)]
public function getAllNotes(): void
{
    // Handle GET /notes
}</code></pre>
        <p>The first argument is the URL path. The second is the HTTP method from the <code>RequestMethod</code> enum.</p>
        <h2>Supported HTTP methods</h2>
        <table>
            <thead>
                <tr>
                    <th>Enum value</th>
                    <th>HTTP method</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>RequestMethod::GET</code></td>
                    <td>GET</td>
                </tr>
                <tr>
                    <td><code>RequestMethod::POST</code></td>
                    <td>POST</td>
                </tr>
                <tr>
                    <td><code>RequestMethod::PUT</code></td>
                    <td>PUT</td>
                </tr>
                <tr>
                    <td><code>RequestMethod::PATCH</code></td>
                    <td>PATCH</td>
                </tr>
                <tr>
                    <td><code>RequestMethod::DELETE</code></td>
                    <td>DELETE</td>
                </tr>
            </tbody>
        </table>
        <h2>URL parameters</h2>
        <p>Route paths can include placeholders. Constants are defined globally when Sparkframe loads:</p>
        <table>
            <thead>
                <tr>
                    <th>Constant</th>
                    <th>Value</th>
                    <th>Method parameter type</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>INT_ROUTE_PROPERTY</code></td>
                    <td><code>{:int}</code></td>
                    <td><code>int</code></td>
                </tr>
                <tr>
                    <td><code>STR_ROUTE_PROPERTY</code></td>
                    <td><code>{:str}</code></td>
                    <td><code>string</code></td>
                </tr>
                <tr>
                    <td><code>WILDCARD_ROUTE_PROPERTY</code></td>
                    <td><code>*</code></td>
                    <td>matches the rest of the URI</td>
                </tr>
            </tbody>
        </table>
        <p>Shorthand aliases: <code>INT_RP</code>, <code>STR_RP</code>, <code>WILD_RP</code>.</p>
        <h3>Integer parameter</h3>
        <pre><code class="language-php">#[Route('/notes/get/' . INT_ROUTE_PROPERTY, RequestMethod::GET)]
public function getNote(int $id): void
{
    // GET /notes/get/42 → $id = 42
}</code></pre>
        <p>The method parameter name does not matter; position matches the placeholder order.</p>
        <h3>String parameter</h3>
        <pre><code class="language-php">#[Route('/users/' . STR_ROUTE_PROPERTY, RequestMethod::GET)]
public function getUser(string $username): void
{
    // GET /users/alice → $username = 'alice'
}</code></pre>
        <h2>Multiple routes on one method</h2>
        <p>The <code>#[Route]</code> attribute is repeatable. Use it when the same action should respond to more than one URL:</p>
        <pre><code class="language-php">#[Route('/notes/get-all', RequestMethod::GET)]
#[Route('/notes', RequestMethod::GET)]
public function getAllNotes(): void
{
    // Handles both GET /notes/get-all and GET /notes
}</code></pre>
        <h2>Add a route to an existing controller</h2>
        <ol>
            <li>Open the controller in <code>src/Controller/</code>.</li>
            <li>Add a public method with a return type of <code>void</code>.</li>
            <li>Place one or more <code>#[Route(...)]</code> attributes above the method.</li>
            <li>If the path has <code>{:int}</code> or <code>{:str}</code>, add a matching typed parameter to the method signature.</li>
        </ol>
        <p>Example — add a search route to <code>NotesController</code>:</p>
        <pre><code class="language-php">#[Route('/notes/search/' . STR_ROUTE_PROPERTY, RequestMethod::GET)]
public function searchNotes(string $query): void
{
    // Implement search logic
}</code></pre>
        <p>No registration step is needed. The route is active on the next request.</p>
        <h2>Create a new controller with routes</h2>
        <ol>
            <li>Create <code>src/Controller/ArchiveController.php</code>:</li>
        </ol>
        <pre><code class="language-php">&lt;?php

declare(strict_types=1);

namespace App\Controller;

use Sparkframe\Attributes\Route;
use Sparkframe\Controller\Controller;
use Sparkframe\Tools\RequestMethod;

class ArchiveController extends Controller
{
    #[Route('/archive', RequestMethod::GET)]
    public function index(): void
    {
        $this-&gt;render('archive/index', []);
    }
}</code></pre>
        <ol>
            <li>The framework discovers the file automatically (see <a href="/documentation/application-structure">Application structure</a>).</li>
            <li>Visit <code>/archive</code> in your browser.</li>
        </ol>
        <h2>How routing works (briefly)</h2>
        <p>On bootstrap, the framework reflects over every discovered controller, reads <code>#[Route]</code> attributes on public methods, and builds a route table. When a request arrives, <code>RequestHandler</code> finds the first route that matches both the URI and the HTTP method, then calls the method with extracted URL parameters.</p>
        <p>You do not need to understand this to use routing. It explains why adding a file is enough — no manual registration.</p>
        <h2>Debugging routes</h2>
        <p><code>MainController</code> in firestarter lists all registered routes on the homepage by calling <code>Router::getRoutes()</code>. This is useful during development to verify your routes are discovered.</p>
        <p>Do not rely on this in production; it is a debug aid only.</p>
        <nav class="documentation-pager" aria-label="Page navigation">
            <a href="/documentation/configuration" role="button" class="secondary">Previous</a>
            <span class="documentation-pager__topic documentation-pager__topic--prev">Configuration</span>
            <span class="documentation-pager__topic documentation-pager__topic--next">Controllers</span>
            <a href="/documentation/controllers" role="button">Next</a>
        </nav>
    </article>
</div>