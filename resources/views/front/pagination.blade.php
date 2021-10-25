  <!-- start pagination area -->
  @if ($paginator->hasPages())
      <div class="paginatoin-area text-center">

          <ul class="pagination-box">

              @if ($paginator->onFirstPage())
                  <li><a class="previous" href="#" style="pointer-events: none"><i class="pe-7s-angle-left"></i></a>

                  @else
                  <li><a class="previous" href="{{ $paginator->previousPageUrl() }}"><i
                              class="pe-7s-angle-left"></i></a> </li>

              @endif
              @foreach ($elements as $element)
                  {{-- "Three Dots" Separator --}}
                  @if (is_string($element))
                      <li><a href="#" style="pointer-events: none">{{ $element }}</a></li>

                  @endif

                  {{-- Array Of Links --}}
                  @if (is_array($element))
                      @foreach ($element as $page => $url)
                          @if ($page == $paginator->currentPage())
                              <li class="active"><a href="#">{{ $page }}</a></li>

                          @else
                              <li><a href="{{ $url }}">{{ $page }}</a></li>
                          @endif
                      @endforeach
                  @endif
              @endforeach

              @if ($paginator->hasMorePages())
                  <li><a class="next" href="{{ $paginator->nextPageUrl() }}"><i class="pe-7s-angle-right"></i></a>
                  </li>

              @else
                  <li><a class="next" href="#" style="pointer-events: none"><i class="pe-7s-angle-right"></i></a>
              @endif

          </ul>
      </div>
  @endif
  <!-- end pagination area -->
