<?php

namespace App\Services;

use Statamic\Fieldtypes\Bard\Marks\Small;
use Tiptap\Extensions\StarterKit;
use Tiptap\Extensions\TextAlign;
use Tiptap\Marks\Highlight;
use Tiptap\Marks\Link;
use Tiptap\Marks\Subscript;
use Tiptap\Marks\Superscript;
use Tiptap\Marks\Underline;
use Tiptap\Nodes\Table;
use Tiptap\Nodes\TableCell;
use Tiptap\Nodes\TableRow;

class EditorService
{
    public function editor()
    {
        return app()->makeWith(\Tiptap\Editor::class, [
            'configuration' => [
                'extensions' => [
                    new StarterKit(),
                    new Link([
                        'HTMLAttributes' => [
                            'target' => '',
                            'rel' => '',
                        ]
                    ]),
                    new Underline(),
                    new Subscript(),
                    new Superscript(),
                    new Highlight(),
                    new Table(),
                    new TableRow(),
                    new TableCell(),
                    new Small(),
                    new TextAlign(['types' => ['heading', 'paragraph']]),
                ],
            ],
        ]);
    }
}
