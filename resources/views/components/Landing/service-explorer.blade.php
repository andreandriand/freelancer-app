<a href="{{ route('detail.landing', $serv->id) }}" class="block">
    <div class="w-auto h-auto overflow-hidden md:p-5 p-4 bg-white rounded-2xl inline-block">
        <div class="flex items-center space-x-2 mb-6">
            <!--Author's profile photo-->
            @if ($serv->user->detail_user->photo != null)
                <img class="w-14 h-14 object-cover object-center rounded-full mr-1"
                    src="{{ url(Storage::url($serv->user->detail_user->photo)) }}" alt="user photo" loading="lazy" />
            @else
                <img class="w-14 h-14 object-cover object-center rounded-full mr-1"
                    src="{{ asset('assets/images/pp.svg') }}" alt="Profile Photo">
            @endif
            <div>
                <!--Author name-->
                <p class="text-gray-900 font-semibold text-lg">{{ $serv->user->name ?? '' }}</p>
                <p class="text-serv-text font-light text-md">
                    {{ $serv->user->detail_user->role ?? '' }}
                </p>
            </div>
        </div>

        <!--Banner image-->
        @if (isset($serv->thumbnail_service[0]) && $serv->thumbnail_service[0]->thumbnail != null)
            <img class="rounded-2xl w-full object-cover h-48"
                src="{{ Storage::url($serv->thumbnail_service[0]->thumbnail) }}" alt="banner photo" loading="lazy" />
        @else
            <img class="rounded-2xl w-full" src="{{ url('https://via.placeholder.com/750x500') }}" alt="placeholder" />
        @endif

        <!--Title-->
        <h1 class="font-semibold text-gray-900 text-lg mt-1 leading-normal py-4">
            {{ $serv->title ?? '' }}
        </h1>
        <!--Description-->
        <div class="max-w-full">
            @include('components.landing.rating')
        </div>

        <div class="text-center mt-5 flex justify-between w-full">
            <span class="text-serv-text mr-3 inline-flex items-center leading-none text-md py-1 ">
                Price starts from:
            </span>
            <span class="text-serv-button inline-flex items-center leading-none text-md font-semibold">
                Rp {{ number_format($serv->price, 0, ',', '.') }}
            </span>
        </div>
    </div>
</a>
