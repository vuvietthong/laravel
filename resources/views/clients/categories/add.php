<form action="<?= route('categories.add') ?>" method="post" enctype="multipart/form-data">
    <input type="text" name="category_name" id="category_name" placeholder="Tên chuyên mục"/>
    <input type="hidden" name="_token" value="<?= csrf_token() ; ?>">
    <button type="submit" name="btn-submit">Thêm chuyên mục</button>
</form>
