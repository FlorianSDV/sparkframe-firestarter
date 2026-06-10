<div class="documentation-layout">
    <?php require __DIR__ . '/_nav.php'; ?>
    <article class="documentation-content">
<h1>Configuration</h1>
<p>Sparkframe loads configuration from a <code>.env</code> file in your project root. Database connections are registered in a <code>DatabaseInfoCollection</code> class.</p>
<h2>Environment variables</h2>
<p>When you call <code>initializeGlobals($root_dir)</code>, the framework loads <code>.env</code> using <a href="https://github.com/vlucas/phpdotenv">vlucas/phpdotenv</a>. Variables are available as <code>$_ENV[&#039;VARIABLE_NAME&#039;]</code>.</p>
<p>Copy <code>.env.example</code> to <code>.env</code> and adjust values for your environment:</p>
<pre><code>DB_URL_SQLITE=sqlite:/var/www/html/sqlite_db/notes-app.sqlite

DB_URL_MYSQL=mysql:host=db;dbname=notes_app
MYSQL_ROOT_PASSWORD=root
MYSQL_USER=root

COMPOSER_AUTH_PATH=/path/to/auth.json
XDEBUG_HOST_PORT=9003</code></pre>
<table><thead><tr><th>Variable</th><th>Purpose</th></tr></thead><tbody><tr><td><code>DB_URL_SQLITE</code></td><td>PDO DSN for SQLite (path to the <code>.sqlite</code> file)</td></tr><tr><td><code>DB_URL_MYSQL</code></td><td>PDO DSN for MySQL (<code>host</code> and <code>dbname</code>)</td></tr><tr><td><code>MYSQL_USER</code></td><td>MySQL username</td></tr><tr><td><code>MYSQL_ROOT_PASSWORD</code></td><td>MySQL password</td></tr><tr><td><code>COMPOSER_AUTH_PATH</code></td><td>Path to Composer <code>auth.json</code> (Docker builds only)</td></tr><tr><td><code>XDEBUG_HOST_PORT</code></td><td>Xdebug port (development only)</td></tr></tbody></table>
<p>Sparkframe does not validate that required variables exist. If a variable is missing, your app will fail when it tries to connect.</p>
<h2>Database connections</h2>
<p>Create a class that extends <code>Sparkframe\Database\BaseDatabaseInfoCollection</code> and maps <strong>named</strong> databases to <code>DatabaseInfo</code> objects:</p>
<pre><code>&lt;?php

declare(strict_types=1);

namespace App\Bootstrap;

use Sparkframe\Database\BaseDatabaseInfoCollection;
use Sparkframe\Database\DatabaseInfo;

class DatabaseInfoCollection extends BaseDatabaseInfoCollection
{
    public function __construct()
    {
        $this-&gt;database_info_collection = [
            'SqLite' =&gt; new DatabaseInfo(
                $_ENV['DB_URL_SQLITE'],
                'root',
                ''
            ),
            'MySQL' =&gt; new DatabaseInfo(
                $_ENV['DB_URL_MYSQL'],
                $_ENV['MYSQL_USER'],
                $_ENV['MYSQL_ROOT_PASSWORD']
            ),
        ];
    }
}</code></pre>
<p>Each key (<code>&#039;SqLite&#039;</code>, <code>&#039;MySQL&#039;</code>) is a name you reference from your models. The <code>DatabaseInfo</code> constructor takes:</p>
<ol><li><strong>DSN</strong> — PDO connection string</li><li><strong>Username</strong></li><li><strong>Password</strong></li></ol>
<p>You can register one or more databases. The framework picks the correct wrapper (MySQL or SQLite) based on the DSN.</p>
<h2>Switching databases in a model</h2>
<p>When you construct a model, pass the database name as the second argument:</p>
<pre><code>// Use SQLite
parent::__construct(NoteEntity::class, 'SqLite');

// Use MySQL
parent::__construct(NoteEntity::class, 'MySQL');</code></pre>
<p>Only one database is active per model instance. To use both in the same request, create separate model instances or switch the constructor argument.</p>
<h2>Creating database tables</h2>
<p>Sparkframe has no migration system. You create tables yourself:</p>
<ul><li>Run SQL manually</li><li>Use a setup script invoked via Composer</li></ul>
<p>Firestarter includes setup scripts as an <strong>application pattern</strong>, not a framework feature:</p>
<pre><code>composer create-sqlite-db   # Creates SQLite file and Notes table
composer create-mysql-db    # Creates MySQL database and Notes table</code></pre>
<p>These scripts live in <code>sqlite_db/</code> and <code>MySql/</code> in the firestarter project. Copy and adapt them for your own entities.</p>
<h2>Local development without Docker</h2>
<p>For running on your host machine, use <code>.env.local.example</code> as a template. You may need to set <code>DB_URL_SQLITE</code> to the absolute path of your SQLite file.</p>
<p>See the project <a href="/">Readme.md</a> for full installation and Docker instructions.</p>
<h2>Next steps</h2>
<ul><li><a href="/documentation/models-and-query-builder">Models and query builder</a> — use a configured database in your models</li><li><a href="/documentation/application-structure">Application structure</a> — where configuration fits in the bootstrap</li></ul>
    </article>
</div>
