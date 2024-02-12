import ace from 'ace-builds/src-noconflict/ace';
import 'ace-builds/src-noconflict/theme-monokai';
import 'ace-builds/src-noconflict/mode-php';

document.addEventListener("DOMContentLoaded", function() {
    let editor = ace.edit("editor");
    editor.setTheme("ace/theme/monokai");
    editor.session.setMode("ace/mode/php");
    editor.setOptions({
        fontSize: "12pt",
        enableBasicAutocompletion: true,
        enableSnippets: true,
        enableLiveAutocompletion: true
    });

    let baseText = "<?php\n" +
        "\n" +
        "namespace App\\Console\\Commands;\n" +
        "\n" +
        "use Illuminate\\Console\\Command;\n" +
        "\n" +
        "class <<classname>> extends Command\n" +
        "{\n" +
        "    protected $signature = 'command:name';\n" +
        "    protected $description = 'Command description';\n" +
        "\n" +
        "    public function handle()\n" +
        "    {\n" +
        "        return Command::SUCCESS;\n" +
        "    }\n" +
        "}\n";
    editor.setValue(baseText);
});

