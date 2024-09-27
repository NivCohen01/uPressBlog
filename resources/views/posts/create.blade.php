@extends('layouts.app')

@section('title', isset($post) ? 'Edit Post' : 'Create Post')

@section('content')
    <h1>{{ isset($post) ? 'Edit Post' : 'Create Post' }}</h1>
    
    @php
        use App\Helpers\ContentParser;

        $parsedContent = isset($post) ? json_decode($post->content, true) : null;
        if ($parsedContent) {
            // Convert the parsed content back to HTML for CKEditor
            $postContent = '';
            foreach ($parsedContent as $block) {
                $postContent .= ContentParser::createHTMLElement($block);
            }
        }
    @endphp

    <form action="{{ isset($post) ? route('posts.update', $post->id) : route('posts.store') }}" method="POST" id="post-form">
        @csrf
        @if(isset($post))
            @method('PUT')
        @endif
        <div class="mb-3">
            <label for="title" class="form-label">Title <span class="required-mark">*</span></label>
            <input type="text" class="form-control" id="title" name="title" value="{{ isset($post) ? $post->title : '' }}">
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Content <span class="required-mark">*</span></label>
            <textarea class="form-control" id="content" name="content" rows="5">{{ isset($post) ? $postContent : '' }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">{{ isset($post) ? 'Update' : 'Create' }}</button>
    </form>
@endsection

@section('scripts')
    <script src="{{ asset('js/ckeditor.js') }}"></script>
    <script>
        let editor;
        $(document).ready(function() {
            ClassicEditor
                .create($('#content')[0])
                .then(newEditor => {
                    editor = newEditor;
                    @if(isset($post))
                        editor.setData(JSON.parse(@json($post->content)));
                    @endif
                })
                .catch(error => {
                    console.error(error);
                });

            $('#post-form').on('submit', function(e) {
                e.preventDefault();

                const content = editor.getData();
                const jsonContent = parseContentToJSON(content); 
                const jsonString = JSON.stringify(jsonContent);
                $('<input>').attr({
                    type: 'hidden',
                    name: 'json_content',
                    value: jsonString
                }).appendTo('#post-form');

                this.submit();
            });
        });

        function parseContentToJSON(content) {
            const parser = new DOMParser();
            const doc = parser.parseFromString(content, 'text/html');
            const parsedAnswer = [];

            function parseNode(node) {
                switch (node.nodeName) {
                    case 'P':
                        return { type: 'text', content: parseInlineElements(node) };
                    case 'B':
                    case 'STRONG':
                        return { type: 'bold', content: parseInlineElements(node) };
                    case 'U':
                        return { type: 'underline', content: parseInlineElements(node) };
                    case 'A':
                        return { type: 'link', href: node.getAttribute('href'), text: parseInlineElements(node) };
                    case 'IMG':
                        return { type: 'image', src: node.getAttribute('src'), alt: node.getAttribute('alt') };
                    case 'H1':
                    case 'H2':
                    case 'H3':
                    case 'H4':
                    case 'H5':
                    case 'H6':
                        return { type: node.nodeName.toLowerCase(), content: parseInlineElements(node) };
                    case 'UL':
                    case 'OL':
                        const listItems = [];
                        node.querySelectorAll('li').forEach(li => {
                            listItems.push(parseInlineElements(li));
                        });
                        return { type: node.nodeName.toLowerCase(), items: listItems };
                    case 'TABLE':
                        const tableContent = [];
                        node.querySelectorAll('tr').forEach(tr => {
                            const rowContent = [];
                            tr.querySelectorAll('td, th').forEach(cell => {
                                rowContent.push({
                                    type: cell.nodeName.toLowerCase(),
                                    content: parseInlineElements(cell),
                                    rowspan: cell.getAttribute('rowspan') || 1,
                                    colspan: cell.getAttribute('colspan') || 1
                                });
                            });
                            tableContent.push(rowContent);
                        });
                        return { type: 'table', content: tableContent };
                    default:
                        return { type: 'text', content: parseInlineElements(node) };
                }
            }

            function parseInlineElements(node) {
                const fragments = [];
                node.childNodes.forEach(child => {
                    switch (child.nodeName) {
                        case '#text':
                            fragments.push(child.textContent);
                            break;
                        case 'B':
                        case 'STRONG':
                            fragments.push({ type: 'bold', content: parseInlineElements(child) });
                            break;
                        case 'U':
                            fragments.push({ type: 'underline', content: parseInlineElements(child) });
                            break;
                        case 'A':
                            fragments.push({ type: 'link', href: child.getAttribute('href'), text: parseInlineElements(child) });
                            break;
                        case 'IMG':
                            fragments.push({ type: 'image', src: child.getAttribute('src'), alt: child.getAttribute('alt') });
                            break;
                        case 'I':
                        case 'EM':
                            fragments.push({ type: 'italic', content: parseInlineElements(child) });
                            break;
                        default:
                            fragments.push(parseNode(child));
                            break;
                    }
                });
                return fragments.length > 1 ? fragments : fragments[0];
            }

            doc.body.childNodes.forEach(node => {
                parsedAnswer.push(parseNode(node));
            });

            return parsedAnswer;
        }
    </script>
@endsection
