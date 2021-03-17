<div class="login-popup">
    <div class="form-box">
        <div class="tab tab-nav-simple tab-nav-boxed form-tab">
            <ul class="nav nav-tabs nav-fill" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" href="#signin">Sign in</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#register">Register</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="signin">
                    {!! Form::open(['route' =>'login', 'class' => '', 'id' => 'auth']) !!}
                    <div class="form-group">
                        <label for="singin-email">Username or email address:</label>
                        {!! Form::text('login', null, ['autofocus', 'class' => 'form-control','id' =>
                        'singin-email','placeholder' =>
                        'Username or Email']) !!}
                    </div>
                    <div class="form-group">
                        <label for="singin-password">Password:</label>

                        {!! Form::password('password', ['class' => 'form-control', 'id' =>
                        'singin-password','placeholder' =>
                        'Secure Password']) !!}

                    </div>
                    <div class="form-footer">
                        <button class="btn btn-primary btn-block" type="submit">Sign in</button>
                        <div class="form-checkbox">
                        </div>
                        <!-- <a href="" class="lost-link font-secondary">Lost your password?</a> -->
                    </div>
                    {!! Form::close() !!}
                </div>
                <div class="tab-pane" id="register">
                    {!! Form::open(['route' =>'register', 'class' => '', 'id' => 'auth']) !!}
                    <div class="form-group">
                        <label for="singin-email">Name:</label>
                        {!! Form::text('name', null, ['autofocus', 'class' => 'form-control','id' =>
                        'register-email','placeholder' =>
                        'Name']) !!}
                    </div>
                    <div class="form-group">
                        <label for="singin-email">Username:</label>
                        {!! Form::text('username', null, ['autofocus', 'class' => 'form-control','id' =>
                        'register-email','placeholder' =>
                        'Username']) !!}
                    </div>
                    <div class="form-group">
                        <label for="singin-email">Your email address:</label>
                        {!! Form::text('email', null, ['autofocus', 'class' => 'form-control','id' =>
                        'register-email','placeholder' =>
                        'Email']) !!}
                    </div>
                    <div class="form-group">
                        <label for="singin-password">Password:</label>
                        {!! Form::password('password', ['class' => 'form-control', 'id' =>
                        'register-password','placeholder' => 'Password']) !!}
                    </div>

                    <div class="form-group">
                        <label for="singin-password">Confirm Password:</label>
                        {!! Form::password('password_confirmation', ['class' => 'form-control', 'id' =>
                        'register-password','placeholder' => 'Confirm Password']) !!}
                    </div>

                    <button class="btn btn-primary btn-block" type="submit">Sign up</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>