<form action="test" method="post" enctype="multipart/form-data">
    <input type="text" name="username" id="username"/>
    <input type="hidden" name="_token" value="<?= csrf_token()  ?>">
    <button type="submit" name="btn-submit">Submit</button>
</form>
@for($i = 0; $i <10 ; $i++)
    <p>Phần tử {{$i}}</p>
@endfor
