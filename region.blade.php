@extends('layout.default')

@section('content')
  <article>
      <section class="azs-advantImg">
          <img src="/images/bg-home-unhdr.jpg" class="azs-advantImg__img img-responsive" alt="">
          <ul class="container azs-advantImg__list">
              <li class="azs-advantImg__list--item">
                  <h2 class="azs-advantImg__list--item_sm"><span class="azs-advantImg__list--item_bg">3000</span>более 3 тысяч<br> АЗС</h2>
              </li>
              <li class="azs-advantImg__list--item">
                  <h2 class="azs-advantImg__list--item_sm"><span class="azs-advantImg__list--item_bg">14</span>Регионов<br> по всему КЗ</h2>
              </li>
              <li class="azs-advantImg__list--item">
                  <h2 class="azs-advantImg__list--item_sm"><span class="azs-advantImg__list--item_bg">104</span>Компании АЗС</h2>
              </li>
              <li class="azs-advantImg__list--item">
                  <h2 class="azs-advantImg__list--item_sm"><span class="azs-advantImg__list--item_bg">23</span>Города<br> Казахстана</h2>
              </li>
          </ul>
      </section>

      <section class="azs-aboutPrj">
          <div class="container">
              <div class="row">
                  <div class="col-md-4 azs-aboutPrj__img">
                      <img src="/images/img-home-1.jpg" alt="">
                  </div>
                  <div class="col-md-8 azs-aboutPrj__txt">
                      <h2 class="azs-aboutPrj__txt--h2">О проекте</h2>
                      <p class="azs-aboutPrj__txt--p">
                          <h3 class="azs-aboutPrj__txt--p_h3">Небольшой текст о проекте, описание, Текст-«рыба» имеет функцию заполнения места.</h3>
                          Не следует, однако забывать, что новая модель организационной деятельности представляет собой интересный эксперимент проверки форм развития. Равным образом новая модель организационной деятельности.
                      </p>
                      <a class="azs-link azs-link--aboutPrj_more" href="#">подробнее</a>
                  </div>
              </div>
          </div>
      </section>

      @if (!$news->isEmpty())
        <section class="azs-saleAnews">
            <h2 class="azs-h2 azs-heading">акции и новости</h2>

            <div class="azs-saleAnews__slider js-azs-saleAnews__slider">
                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">
                        <div class="item active">
                          @foreach($news as $n)
                           <a href="{{ route('news', $n->id) }}" class="azs-saleAnews__slider--slide">
                               <div class="azs-saleAnews__slider--slide_img">
                                   <img src="{{ $n->company->logo }}" alt="">
                               </div>
                               <h3 class="azs-saleAnews__slider--slide_h3">{{ $n->title }}</h3>
                               <span class="azs-saleAnews__slider--slide_date">{{ $n->created_at }}</span>
                           </a>   
                          @endforeach
                        </div>
                    </div>

                    <!-- Left and right controls -->
                    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
            <a class="azs-link azs-link--blk_more" href="#">все акции и новости</a>
        </section>
      @endif
      

      <section>
          <h2 class="azs-h2 azs-heading">карта азс</h2>
          <div>
              <div id="map"></div>
          </div>
          <a class="azs-link azs-link--blk_more" href="{{ route('map') }}">перейти к карте</a>
      </section>

      <section class="container azs-rating">
          <h2 class="azs-h2 azs-heading">рейтинг</h2>
          <div class="row">
              @if (!$popular->isEmpty())
                <div class="col-md-7 azs-rating__blk">
                    <h3 class="azs-h3">Самые популярные</h3>
                    <div class="row">
                      @foreach($popular as $p)
                        <div class="col-md-6 azs-mostPop azs-mostPop--left">
                            <div>
                                <div class="azs-mostPop__imgWrp">
                                    <img class="azs-mostPop__imgWrp--img" src="{{ $p->company->background }}" alt="">
                                    <h2 class="azs-mostPop__imgWrp--title">{{ $p->title }}</h2>
                                </div>
                                <div class="azs-mostPop__brandRait">
                                    <img class="azs-mostPop__brandRait--logo" src="{{ $p->company->logo }}" alt="">
                                    <div class="azs-mostPop__brandRait--stars">
                                        <img src="/images/img-stars-1.png" alt="">
                                    </div>
                                    <mark class="azs-mostPop__brandRait--mark">{{ $p->getAvarageRating() }}</mark>
                                    <span class="azs-mostPop__brandRait--voices">{{ $p->ratings_count }} голосов</span>
                                </div>
                                <div>
                                    <ul class="azs-mostPop__compare">
                                        <li class="azs-mostPop__compare--item">
                                            <h4 class="azs-mostPop__compare--item_name">Качество топлива</h4>
                                            <div class="azs-mostPop__compare--item_bar">
                                                <img src="/images/home-rating-4.5.png" alt="">
                                            </div>
                                            <span class="azs-mostPop__compare--item_num">{{ $p->getAvarageRating('fuel_rating') }}</span>
                                        </li>
                                        <li class="azs-mostPop__compare--item">
                                            <h4 class="azs-mostPop__compare--item_name">Уровень обслуживания</h4>
                                            <div class="azs-mostPop__compare--item_bar">
                                                <img src="/images/home-rating-5.png" alt="">
                                            </div>
                                            <span class="azs-mostPop__compare--item_num">{{ $p->getAvarageRating('handling_rating') }}</span>
                                        </li>
                                        <li class="azs-mostPop__compare--item">
                                            <h4 class="azs-mostPop__compare--item_name">Предоставляемые услуги</h4>
                                            <div class="azs-mostPop__compare--item_bar">
                                                <img src="/images/home-rating-5.png" alt="">
                                            </div>
                                            <span class="azs-mostPop__compare--item_num">{{ $p->getAvarageRating('service_rating') }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                      @endforeach
                    </div>
                </div>
              @endif
              
              @if (!$top_rating->isEmpty())
                <div class="col-md-5 azs-rating__blk">
                    <h3 class="azs-h3">общий рейтинг</h3>
                    <ul class="azs-globalRaiting">
                      @foreach($top_rating as $r)
                        <li class="azs-globalRaiting__item">
                            <span class="azs-globalRaiting__item--num">{{ $r->getAvarageRating() }}</span>
                            <img class="azs-globalRaiting__item--img" src="/images/img-rait-4.8.png" alt="">
                            <div class="azs-globalRaiting__item--logo">
                                <img src="{{ $r->company->logo }}" alt="">
                            </div>
                            <span class="azs-globalRaiting__item--title">{{ $r->title }}</span>
                        </li>
                      @endforeach
                    </ul>
                    <a class="azs-link azs-link--allRait" href="#">весь рейтинг</a>
                </div>
              @endif
          </div>
      </section>

      @if (!$reviews->isEmpty())
        <section class="azs-reviews">
            <h2 class="azs-h2 azs-h2--reviews">Отзывы</h2>
            <div class="azs-reviewsSlider js-azs-reviewsSlider">
                <div id="myCarousel1" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner" role="listbox">
                        @foreach($reviews as $key => $review)
                        <div class="item {{ $key == 0 ? 'active' : '' }}">
                            <div class="azs-reviewsSlider__slide">
                                <div class="azs-reviewsSlider__slideInner">
                                    <p class="azs-reviewsSlider__slideInner--txt">
                                      {!! nl2br($review->body) !!}
                                    </p>
                                    <span class="azs-reviewsSlider__slideInner--date">{{ $review->created_at }}</span>
                                    <span class="azs-reviewsSlider__slideInner--author">{{ $review->user->name }}</span>
                                </div>
                            </div>
                            </div>
                          @endforeach
                            
                        <a class="left carousel-control" href="#myCarousel1" role="button" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="right carousel-control" href="#myCarousel1" role="button" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
            <span class="azs-link azs-link--btn azs-link--btn_reviews" data-reg="false">оставить отзыв</span>
        </section>
      @endif
      

      <section class="azs-main-partners">
          <div class="azs-partner-slider container">
              <h2 class="azs-heading">партнеры</h2>
              <div class="azs-partner-slider__inner row">
                  <div class="azs-partner-slider__nojsfix">
                      <div class="azs-partner-slider__nojsfix--inner owl-carousel">
                          <div class="azs-partner-slider__item
                          ">
                              <img src="/images/home-partn-slide-1.jpg" alt="">
                          </div>
                          <div class="azs-partner-slider__item">
                              <img src="/images/home-partn-slide-2.jpg" alt="">
                          </div>
                          <div class="azs-partner-slider__item">
                              <img src="/images/home-partn-slide-3.jpg" alt="">
                          </div>
                          <div class="azs-partner-slider__item">
                              <img src="/images/home-partn-slide-4.jpg" alt="">
                          </div>
                          <div class="azs-partner-slider__item">
                              <img src="/images/home-partn-slide-5.jpg" alt="">
                          </div>
                          <div class="azs-partner-slider__item">
                              <img src="/images/home-partn-slide-6.jpg" alt="">
                          </div>
                      </div>
                  </div>
                  <div class="azs-partner-slider__arrow azs-partner-slider__arrow--left" data-dir="prev"></div>
                  <div class="azs-partner-slider__arrow azs-partner-slider__arrow--right" data-dir="next"></div>
              </div>
          </div>
      </section>

  </article>
  <div class="modal fade modal-reg">
    <div class="modal-dialog">
      <form action="" class="azs-regLog__item--form">
          <div class="close">X</div>
          <h2>Зарегистрируйтесь чтобы оставить отзыв</h2>
          <input type="text" name="fio" placeholder="ФИО" class="azs-form__input">
          <input type="email" name="email" placeholder="E-mail" class="azs-form__input">
          <input type="text" name="login" placeholder="Логин"  class="azs-form__input">
          <input type="password" name="pass" placeholder="Пароль" class="azs-form__input">
          <input type="submit" value="зарегестрироваться" class="azs-form__submit">
      </form>
    </div>
  </div>
  <div class="modal fade modal-review">
    <div class="modal-dialog">
      <form action="" class="azs-regLog__item--form">
          <textarea></textarea>
          <input type="submit" value="зарегестрироваться" class="azs-form__submit">
      </form>
    </div>
  </div>
  <script type="text/javascript">
    var CURRENT_REGION_ID ={{$region->id}};
</script>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('frontend/js/region_map.js') }}"></script>
@endsection

