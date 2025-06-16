@extends('welcome')
@section('content')
<div class="container">
  <h2>Create Course</h2>
  @if(session('success'))
    <div style="color: green">{{ session('success') }}</div>
  @endif
  @if($errors->any())
    <div style="color: red">{{ $errors->first() }}</div>
  @endif

  <form method="POST" action="/store" id="course-form">
    @csrf
    <div class="form-row" style="display: flex; gap: 20px;">
      <div style="flex: 1;">
        <label for="name">Course Title *</label>
        <input type="text" name="name" placeholder="Course Title" required>
      </div>
      <div style="flex: 1;">
        <label for="category">Category *</label>
        <select id="category" name="category" required>
          <option value="">-- Select --</option>
          <option value="Web Development">Web Development</option>
          <option value="Graphic Design">Graphic Design</option>
          <option value="Data Science">Data Science</option>
          <option value="Marketing">Marketing</option>
        </select>
      </div>
    </div>

    <label for="description">Description</label>
    <textarea id="description" name="description" placeholder="Description"></textarea>

    <br/><br/>
    <button type="button" class="btn-secondary" id="add-module">Add Module +</button>
    <div id="modules-container"></div>
    <button type="submit">Save</button>
  </form>
</div>

<script>
let moduleIndex = 0;

function createModule(index, isDefault = false) {
  return `
    <div class="module" data-index="${index}">
      <div class="module-header">
        <span class="toggle-arrow module-toggle">&#9660;</span>
        <strong>Module ${index + 1}</strong>
        ${!isDefault ? '<span class="remove-btn remove-module">x</span>' : ''}
      </div>
      <div class="module-body">
        <label for="moduleTitle">Module Title *</label>
        <input type="text" name="modules[${index}][title]" placeholder="Module Title" required>
        <button type="button" class="btn-secondary add-content">Add Content +</button>
        <div class="contents">
          ${createContent(index, 0, true)}
        </div>
      </div>
    </div>`;
}

function createContent(moduleIdx, contentIdx, isFirst = false) {
  return `
    <div class="content" data-content-index="${contentIdx}">
      <div class="content-header">
        <span class="toggle-arrow content-toggle">&#9660;</span>
        <strong>Content ${contentIdx + 1}</strong>
        ${!isFirst ? '<span class="remove-btn remove-content">x</span>' : ''}
      </div>
      <div class="content-body">
        <label for="contentType">Content Type *</label>
        <select name="modules[${moduleIdx}][contents][${contentIdx}][type]" required>
          <option value="text">Text</option>
          <option value="image">Image</option>
          <option value="video">Video</option>
          <option value="link">Link</option>
        </select>
        <label for="contentValue">Content Value *</label>
        <input type="text" name="modules[${moduleIdx}][contents][${contentIdx}][value]" placeholder="Content Value" required>
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
  $(this).closest('.module').find('.module-body').slideToggle();
  $(this).toggleClass('rotated');
});

$(document).on('click', '.content-toggle', function() {
  $(this).closest('.content').find('.content-body').slideToggle();
  $(this).toggleClass('rotated');
});
</script>
@endsection
