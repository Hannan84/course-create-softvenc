@extends('welcome')
@section('content')
<h2>Create Course</h2>
@if(session('success'))
    <div style="color: green">{{ session('success') }}</div>
@endif
@if($errors->any())
    <div style="color: red">{{ $errors->first() }}</div>
@endif
<form method="POST" action="/courses" id="course-form">
    @csrf
    <input name="name" placeholder="Course Title" required><br>
    <textarea name="description" placeholder="Description"></textarea><br>
    <input name="category" placeholder="Category"><br>

    <div id="modules-container"></div>
    <button type="button" id="add-module">Add Module</button><br><br>
    <button type="submit">Save Course</button>
</form>

<script>
let moduleIndex = 0;

function createModule(index, isDefault = false) {
    return `
    <div class="module" data-index="${index}">
        <div class="module-header">
            <span class="toggle-arrow module-toggle">&#9660;</span>
            <input type="text" name="modules[${index}][title]" placeholder="Module Title" required>
            ${!isDefault ? '<span class="remove-btn remove-module">[Remove Module]</span>' : ''}
        </div>
        <div class="module-body">
            <div class="contents">
                ${createContent(index, 0, true)}
            </div>
            <button type="button" class="add-content">Add Content</button>
        </div>
    </div>`;
}

function createContent(moduleIdx, contentIdx, isFirst = false) {
    return `
    <div class="content" data-content-index="${contentIdx}">
        <div class="content-header">
            <span class="toggle-arrow content-toggle">&#9660;</span>
            <select name="modules[${moduleIdx}][contents][${contentIdx}][type]">
                <option value="text">Text</option>
                <option value="image">Image</option>
                <option value="video">Video</option>
                <option value="link">Link</option>
            </select>
            ${!isFirst ? '<span class="remove-btn remove-content">[Remove]</span>' : ''}
        </div>
        <div class="content-body">
            <input type="text" name="modules[${moduleIdx}][contents][${contentIdx}][value]" placeholder="Content Value">
        </div>
    </div>`;
}

$(document).ready(function() {
    $('#modules-container').append(createModule(moduleIndex, true));
    moduleIndex++;
});

$('#add-module').click(function() {
    $('#modules-container').append(createModule(moduleIndex));
    moduleIndex++;
});

$(document).on('click', '.add-content', function() {
    const moduleDiv = $(this).closest('.module');
    const modIdx = moduleDiv.data('index');
    const contentCount = moduleDiv.find('.contents .content').length;
    moduleDiv.find('.contents').append(createContent(modIdx, contentCount, contentCount === 0));
});

$(document).on('click', '.remove-module', function() {
    $(this).closest('.module').remove();
});

$(document).on('click', '.remove-content', function() {
    $(this).closest('.content').remove();
});

$(document).on('click', '.module-toggle', function() {
    $(this).closest('.module').find('.module-body').first().slideToggle();
    $(this).toggleClass('rotated');
});

$(document).on('click', '.content-toggle', function() {
    $(this).closest('.content').find('.content-body').first().slideToggle();
    $(this).toggleClass('rotated');
});
</script>
@endsection
