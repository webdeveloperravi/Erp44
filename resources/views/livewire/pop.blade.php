<div>
    <!--success pop up-->

    @if ($show)
        <div id="success_popup">

            <div class="wrapperAlert position-relative">

                <div class="contentAlert">

                    <div class="topHalf">
                        <span
                            style="position: absolute;top: 4%;right: 5%;font-size: 2rem;font-weight: 200;z-index:99999999999999;cursor: pointer;"
                            wire:click="hide"><i class="fa fa-times"></i></span>
                        <p><svg viewBox="0 0 512 512" width="100" title="check-circle">
                                <path
                                    d="M504 256c0 136.967-111.033 248-248 248S8 392.967 8 256 119.033 8 256 8s248 111.033 248 248zM227.314 387.314l184-184c6.248-6.248 6.248-16.379 0-22.627l-22.627-22.627c-6.248-6.249-16.379-6.249-22.628 0L216 308.118l-70.059-70.059c-6.248-6.248-16.379-6.248-22.628 0l-22.627 22.627c-6.248 6.248-6.248 16.379 0 22.627l104 104c6.249 6.249 16.379 6.249 22.628.001z" />
                            </svg></p>
                        <h4 class="text-uppercase ">{{ $head }}</h4>

                        <ul class="bg-bubbles">
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                        </ul>
                    </div>

                    <div class="bottomHalf">

                        <p x-html=" pop_message">{{ $message }}</p>
                        <div class="d-flex" x-show="pop_show_btns">
                            <button id="alertMO"><a href="{{ route('9gem_user_cart') }}" class="text-light">View
                                    Cart</a></button>
                            <button id="alertMO" class="ml-2"><a href="{{ route('9gem_user_checkout') }}"
                                    class="text-light">Checkout</a></button>

                        </div>

                    </div>

                </div>

            </div>


        </div>
        <!--/success pop up-->
    @endif



</div>
