<!DOCTYPE html>
<html>
    <body class="antialiased">

        <div>
            <form method="post" action="/upload" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Upload Video File</label>
                    <input type="file" name="video">

                    @if($errors->has('video'))
                        <span class="text-danger">
                            {{$errors->first('video')}}
                        </span>
                    @endif
                </div>

                <div class="form-group">
                    <input type="submit">
                </div>

                {{csrf_field()}}
            </form>

    </body>
</html>
