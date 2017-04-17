<div class="row">
    @if (!Auth::check())
        <div class="azs-regLog col-md-12">
            <div class="azs-regLog__item">
                <span class="azs-regLog__item--btn">Регистрация</span>
                <form action="{{ url('/register') }}" method="POST" class="azs-regLog__item--form azs-form">
                    {{ csrf_field() }}
                    <input type="text" name="name" placeholder="ФИО" required class="azs-form__input">
                    <input type="email" name="email" placeholder="E-mail" required class="azs-form__input">
                    <input type="password" name="password" placeholder="Пароль" required class="azs-form__input">
                    <input type="password" name="password_confirmation" placeholder="Подтвердите пароль" required class="azs-form__input">
                    <input type="submit" value="зарегестрироваться" class="azs-form__submit">
                </form>
            </div>
            <div class="azs-regLog__item">
                <span class="azs-regLog__item--btn azs-regLog__item--btn_lst azs-regLog__item--last azs-regLog__item--borLft_wht">Войти</span>
                <form action="{{ url('/login') }}" method="POST" class="azs-regLog__item--form azs-form">
                    {{ csrf_field() }}
                    <input type="text" name="email" placeholder="Email" value="{{ old('email') }}" class="azs-form__input" required>
                    <input type="password" name="password" placeholder="Пароль" required class="azs-form__input">
                    <div class="row">
                        <a href="#" class="azs-link--fogPsw col-md-7">Забыли пароль?</a>
                        <input type="submit" value="Войти" class="azs-form__submit col-md-5">
                    </div>
                </form>
            </div>
        </div>
    @else
    <div class="pull-right azs-regLog ">
        {{ Auth::user()->name }} &nbsp;
        <a href="{{ url('/logout') }}">Выйти</a>
    </div>
    @endif
</div>