@extends(env('THEME').'.layouts.site')

@section('content')

    <div class="content group">
        <form id="contact-form-contact-us" class="contact-form" method="post" action="{{ url('/login') }}">

            {{ csrf_field() }}

            <fieldset>
                <ul>
                    <li class="text-field">
                        <label for="login">
                            <span class="label">Name</span>
                            <br />					<span class="sublabel">This is the name</span><br />
                        </label>
                        <div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span><input type="text" name="login" id="login" class="required" value="" /></div>
                    </li>
                    <li class="text-field">
                        <label for="password">
                            <span class="label">Password</span>
                            <br />					<span class="sublabel">This is a field password</span><br />
                        </label>
                        <div class="input-prepend"><span class="add-on"><i class="icon-lock"></i></span><input type="password" name="password" id="password" class="required" value="" /></div>
                    </li>
                    <li class="submit-button">
                        <input type="submit" name="yit_sendmail" value="Отправить" class="sendmail alignright" />
                    </li>
                </ul>
            </fieldset>
        </form>
    </div>



@endsection