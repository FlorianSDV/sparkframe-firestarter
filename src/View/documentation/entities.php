<div class="documentation-layout">
    <?php require __DIR__ . '/_nav.php'; ?>
    <article class="documentation-content">
<h1>Entities</h1>
<p>An entity is a PHP class that maps to a database table. The query builder uses entity metadata to build SQL and hydrate query results into objects.</p>
<h2>Base class</h2>
<p>Extend <code>Sparkframe\Entity\Entity</code> and annotate your properties:</p>
<pre><code class="language-php">&lt;?php

declare(strict_types=1);

namespace App\Entity;

use Sparkframe\Attributes\Column;
use Sparkframe\Attributes\Primary;
use Sparkframe\Entity\Entity;

class NoteEntity extends Entity
{
    public const string ID = 'id';
    public const string TEXT = 'text';

    #[Primary]
    public int $id;

    #[Column]
    public string $text;
}</code></pre>
<h2>Attributes</h2>
<table><thead><tr><th>Attribute</th><th>Purpose</th></tr></thead><tbody><tr><td><code>#[Primary]</code></td><td>Marks the primary key column (exactly one per entity)</td></tr><tr><td><code>#[Column]</code></td><td>Marks a regular database column</td></tr></tbody></table>
<p>Properties <strong>without</strong> an attribute are ignored by the query builder. You can add computed or transient properties that are not stored in the database.</p>
<h2>Column name constants</h2>
<p>Define constants for column names and use them in your models:</p>
<pre><code class="language-php">public const string ID = 'id';
public const string TEXT = 'text';</code></pre>
<p>This avoids typos in query builder calls:</p>
<pre><code class="language-php">-&gt;where([NoteEntity::ID . ' = ' =&gt; $note_id])
-&gt;select(NoteEntity::ID, NoteEntity::TEXT)</code></pre>
<h2>Create a new entity</h2>
<h3>Step 1 — Create the database table</h3>
<p>Sparkframe has no migrations. Create the table with SQL or a setup script before using the entity.</p>
<pre><code class="language-sql">CREATE TABLE Tags (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL
);</code></pre>
<h3>Step 2 — Create the entity class</h3>
<p>Create <code>src/Entity/TagEntity.php</code>:</p>
<pre><code class="language-php">&lt;?php

declare(strict_types=1);

namespace App\Entity;

use Sparkframe\Attributes\Column;
use Sparkframe\Attributes\Primary;
use Sparkframe\Entity\Entity;

class TagEntity extends Entity
{
    public const string ID = 'id';
    public const string NAME = 'name';

    #[Primary]
    public int $id;

    #[Column]
    public string $name;
}</code></pre>
<h3>Step 3 — Match PHP types to column types</h3>
<p>Use PHP types that match your database columns:</p>
<table><thead><tr><th>Database type</th><th>PHP type</th></tr></thead><tbody><tr><td>INTEGER, INT</td><td><code>int</code></td></tr><tr><td>TEXT, VARCHAR</td><td><code>string</code></td></tr><tr><td>REAL, FLOAT</td><td><code>float</code></td></tr></tbody></table>
<p>The entity constructor hydrates properties from database rows using these types.</p>
<h2>How entities are used</h2>
<h3>Hydration from SELECT queries</h3>
<p>When you call <code>execute()</code> on a select query, each row becomes an entity instance:</p>
<pre><code class="language-php">/** @var NoteEntity[] */
$notes = $this-&gt;selectQuery()-&gt;execute();</code></pre>
<h3>Manual construction</h3>
<p>Create an entity before inserting:</p>
<pre><code class="language-php">$new_note = new NoteEntity();
$new_note-&gt;text = 'Hello world';</code></pre>
<p>You do not need to set the primary key before insert; the database assigns it.</p>
<h3>After INSERT</h3>
<p>After a successful insert, the query builder calls <code>setId()</code> on the entity with the new <code>lastInsertId</code>:</p>
<pre><code class="language-php">$this-&gt;insertQuery()
    -&gt;addEntity($new_note)
    -&gt;execute();

// $new_note-&gt;id is now set</code></pre>
<h3>UPDATE and DELETE</h3>
<p>Pass existing entities (with a primary key set) to update or delete builders:</p>
<pre><code class="language-php">$note-&gt;text = 'Updated text';
$this-&gt;updateQuery()-&gt;addEntity($note)-&gt;execute();

$this-&gt;deleteQuery()-&gt;addEntity($note)-&gt;execute();</code></pre>
<h2>Entity helper methods</h2>
<p>These methods are available on every entity (you rarely call them directly in application code):</p>
<table><thead><tr><th>Method</th><th>Description</th></tr></thead><tbody><tr><td><code>getColumnNames()</code></td><td>All annotated column names</td></tr><tr><td><code>getPrimaryKeyColumnName()</code></td><td>Primary key column name</td></tr><tr><td><code>getValuesArray()</code></td><td><code>[&#039;column&#039; =&gt; value]</code> for queries</td></tr><tr><td>`setId(int\</td><td>string $id)`</td><td>Set primary key after insert</td></tr></tbody></table>
<h2>Next steps</h2>
<ul><li><a href="/documentation/models-and-query-builder">Models and query builder</a> — use entities in your data layer</li><li><a href="/documentation/configuration">Configuration</a> — ensure your database table exists</li></ul>
    </article>
</div>
