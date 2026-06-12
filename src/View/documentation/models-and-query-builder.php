<div class="documentation-layout">
    <?php require __DIR__ . '/_nav.php'; ?>
    <article class="documentation-content">
<h1>Models and query builder</h1>
<p>Models connect your entities to database tables. The query builder provides a fluent API for SELECT, INSERT, UPDATE, and DELETE operations.</p>
<h2>Model basics</h2>
<h3>Extend Model</h3>
<pre><code class="language-php">&lt;?php

declare(strict_types=1);

namespace App\Model;

use App\Entity\NoteEntity;
use Sparkframe\Model\Model;

class NotesModel extends Model
{
    protected const string TABLE_NAME = 'Notes';

    public function __construct()
    {
        parent::__construct(NoteEntity::class, 'MySQL');
    }
}</code></pre>
<table><thead><tr><th>Constructor argument</th><th>Purpose</th></tr></thead><tbody><tr><td><code>NoteEntity::class</code></td><td>Entity class used for hydration and column metadata</td></tr><tr><td><code>&#039;MySQL&#039;</code></td><td>Named database from your <a href="/documentation/configuration">DatabaseInfoCollection</a></td></tr></tbody></table>
<h3>Factory methods</h3>
<p>Each model provides four query builders:</p>
<table><thead><tr><th>Method</th><th>Operation</th></tr></thead><tbody><tr><td><code>selectQuery()</code></td><td>SELECT</td></tr><tr><td><code>insertQuery()</code></td><td>INSERT</td></tr><tr><td><code>updateQuery()</code></td><td>UPDATE</td></tr><tr><td><code>deleteQuery()</code></td><td>DELETE</td></tr></tbody></table>
<h2>Create a new model</h2>
<h3>Step 1 — Create the entity</h3>
<p>See <a href="/documentation/entities">Entities</a>. You need an entity class and a database table.</p>
<h3>Step 2 — Create the model class</h3>
<p>Create <code>src/Model/TagsModel.php</code>:</p>
<pre><code class="language-php">&lt;?php

declare(strict_types=1);

namespace App\Model;

use App\Entity\TagEntity;
use Sparkframe\Model\Model;

class TagsModel extends Model
{
    protected const string TABLE_NAME = 'Tags';

    public function __construct()
    {
        parent::__construct(TagEntity::class, 'MySQL');
    }

    /** @return TagEntity[] */
    public function getAll(): array
    {
        return $this-&gt;selectQuery()
            -&gt;select(TagEntity::ID, TagEntity::NAME)
            -&gt;execute();
    }

    public function getById(int $id): TagEntity
    {
        return $this-&gt;selectQuery()
            -&gt;where([TagEntity::ID . ' = ' =&gt; $id])
            -&gt;execute()[0];
    }

    public function create(array $data): TagEntity
    {
        $tag = new TagEntity();
        $tag-&gt;name = $data['name'];
        $this-&gt;insertQuery()-&gt;addEntity($tag)-&gt;execute();
        return $tag;
    }
}</code></pre>
<h3>Step 3 — Use the model in a controller</h3>
<pre><code class="language-php">$this-&gt;tagsModel = new TagsModel();</code></pre>
<h2>SELECT query builder</h2>
<h3>Basic select</h3>
<pre><code class="language-php">$notes = $this-&gt;selectQuery()
    -&gt;select(NoteEntity::ID, NoteEntity::TEXT)
    -&gt;execute();</code></pre>
<p>Omit column arguments to select <code>*</code>:</p>
<pre><code class="language-php">$notes = $this-&gt;selectQuery()-&gt;execute();</code></pre>
<h3>WHERE conditions</h3>
<p>Conditions use an array where keys are SQL fragments and values are bound parameters:</p>
<pre><code class="language-php">$this-&gt;selectQuery()
    -&gt;where([NoteEntity::ID . ' = ' =&gt; $note_id])
    -&gt;execute();</code></pre>
<p>Multiple keys in one <code>where()</code> call are combined with AND:</p>
<pre><code class="language-php">-&gt;where([
    NoteEntity::ID . ' &gt; ' =&gt; 0,
    NoteEntity::TEXT . ' != ' =&gt; '',
])</code></pre>
<h3>WHERE IN / NOT IN</h3>
<pre><code class="language-php">-&gt;whereIn(NoteEntity::ID, [1, 2, 3])
-&gt;whereNotIn(NoteEntity::ID, [4, 5])</code></pre>
<p>Pass another select query as a subquery:</p>
<pre><code class="language-php">$subquery = $this-&gt;selectQuery()-&gt;select(NoteEntity::ID);
$this-&gt;selectQuery()
    -&gt;whereIn(NoteEntity::ID, $subquery)
    -&gt;execute();</code></pre>
<p>Subqueries must select <strong>exactly one column</strong>, or the builder throws <code>IncorrectSubquerySelectException</code>.</p>
<h3>OR conditions</h3>
<p><code>or()</code> requires a preceding <code>where()</code>:</p>
<pre><code class="language-php">$this-&gt;selectQuery()
    -&gt;where([NoteEntity::ID . ' = ' =&gt; 1])
    -&gt;or([NoteEntity::ID . ' = ' =&gt; 2])
    -&gt;execute();</code></pre>
<p>OR variants for IN:</p>
<pre><code class="language-php">-&gt;orIn(NoteEntity::ID, [3, 4])
-&gt;orNotIn(NoteEntity::ID, [5, 6])</code></pre>
<h3>LIMIT</h3>
<pre><code class="language-php">$this-&gt;selectQuery()
    -&gt;limit(10)
    -&gt;execute();</code></pre>
<h3>Debugging</h3>
<p>Get the generated SQL without executing:</p>
<pre><code class="language-php">$sql = $this-&gt;selectQuery()
    -&gt;where([NoteEntity::ID . ' = ' =&gt; 1])
    -&gt;getQuery();</code></pre>
<h3>Reuse a builder</h3>
<p>Call <code>cleanUp()</code> to reset a builder instance for another query:</p>
<pre><code class="language-php">$query = $this-&gt;selectQuery()-&gt;where([NoteEntity::ID . ' = ' =&gt; 1]);
$results = $query-&gt;execute();
$query-&gt;cleanUp()-&gt;where([NoteEntity::ID . ' = ' =&gt; 2]);
$more = $query-&gt;execute();</code></pre>
<h2>INSERT query builder</h2>
<pre><code class="language-php">$new_note = new NoteEntity();
$new_note-&gt;text = $note_data['text'];

$this-&gt;insertQuery()
    -&gt;addEntity($new_note)
    -&gt;execute();

// $new_note-&gt;id is set automatically</code></pre>
<ul><li>Add one or more entities with <code>addEntity()</code>.</li><li>Insert runs inside a transaction.</li><li>After insert, the primary key is assigned via <code>setId()</code>.</li></ul>
<h2>UPDATE query builder</h2>
<pre><code class="language-php">$note-&gt;text = 'New text';

$this-&gt;updateQuery()
    -&gt;addEntity($note)
    -&gt;execute();</code></pre>
<ul><li>Updates all <code>#[Column]</code> properties on the entity.</li><li>WHERE clause uses the <code>#[Primary]</code> property.</li><li>The entity must have its primary key set.</li></ul>
<h2>DELETE query builder</h2>
<pre><code class="language-php">$this-&gt;deleteQuery()
    -&gt;addEntity($note)
    -&gt;execute();</code></pre>
<p>Delete multiple entities in one query:</p>
<pre><code class="language-php">$this-&gt;deleteQuery()
    -&gt;addEntity($note1)
    -&gt;addEntity($note2)
    -&gt;execute();</code></pre>
<p>Delete runs inside a transaction.</p>
<h2>Firestarter example: full CRUD</h2>
<pre><code class="language-php">public function getAllNotes(): array
{
    return $this-&gt;selectQuery()
        -&gt;select(NoteEntity::ID, NoteEntity::TEXT)
        -&gt;execute();
}

public function getNote(int $note_id): NoteEntity
{
    return $this-&gt;selectQuery()
        -&gt;where([NoteEntity::ID . ' = ' =&gt; $note_id])
        -&gt;execute()[0];
}

public function createNote(array $note_data): NoteEntity
{
    $new_note = new NoteEntity();
    $new_note-&gt;text = $note_data['text'];
    $this-&gt;insertQuery()-&gt;addEntity($new_note)-&gt;execute();
    return $new_note;
}

public function updateNote(NoteEntity $note): NoteEntity
{
    $this-&gt;updateQuery()-&gt;addEntity($note)-&gt;execute();
    return $note;
}

public function deleteNote(NoteEntity $note): void
{
    $this-&gt;deleteQuery()-&gt;addEntity($note)-&gt;execute();
}</code></pre>
<h2>Important caveats</h2>
<h3>Column names in <code>select()</code> are not parameterized</h3>
<p>Only use trusted column names (your constants), never user input:</p>
<pre><code class="language-php">// Safe
-&gt;select(NoteEntity::ID, NoteEntity::TEXT)

// Unsafe — do not do this
-&gt;select($_GET['column'])</code></pre>
<p>WHERE values are bound as prepared statement parameters and are safe.</p>
<h3>No JOIN or ORDER BY</h3>
<p>The query builder does not support <code>JOIN</code>, <code>LEFT JOIN</code>, or <code>ORDER BY</code>. For complex queries, run raw SQL through PDO or extend the framework.</p>
<h3>Table must exist</h3>
<p>Create tables before using models. See <a href="/documentation/configuration">Configuration</a> for setup scripts.</p>
<nav class="documentation-pager" aria-label="Page navigation">
    <a href="/documentation/entities" role="button" class="secondary">Previous</a>
    <span class="documentation-pager__topic documentation-pager__topic--prev">Entities</span>
    <span class="documentation-pager__topic documentation-pager__topic--next">Views</span>
    <a href="/documentation/views" role="button">Next</a>
</nav>
    </article>
</div>
