@extends('layouts.app')

@section('title', 'My Request')

@section('content')

    @if (count($order))
        <main class="h-full overflow-y-auto">
            <div class="container mx-auto">
                <div class="grid w-full gap-5 px-10 mx-auto md:grid-cols-12">
                    <div class="col-span-8">
                        <h2 class="mt-8 mb-1 text-2xl font-semibold text-gray-700">
                            My Requests
                        </h2>
                        <p class="text-sm text-gray-400">
                            {{ Auth::user()->order_buyer()->count() }} Total Requests
                        </p>
                    </div>
                    <div class="col-span-4 lg:text-right">

                    </div>
                </div>
            </div>

            <section class="container px-6 mx-auto mt-5">
                <div class="grid gap-5 md:grid-cols-12">
                    <main class="col-span-12 p-4 md:pt-0">
                        <div class="px-6 py-2 mt-2 bg-white rounded-xl">
                            <table class="w-full" aria-label="Table">
                                <thead>
                                    <tr class="text-sm font-normal text-left text-gray-900 border-b border-b-gray-600">
                                        <th class="py-4" scope="">Freelancer Name</th>
                                        <th class="py-4" scope="">Service Details</th>
                                        <th class="py-4" scope="">Price</th>
                                        <th class="py-4" scope="">Status</th>
                                        <th class="py-4" scope="">Action</th>
                                    </tr>
                                </thead>

                                <tbody class="bg-white">
                                    @forelse ($order as $req)
                                        <tr class="text-gray-700 border-b">
                                            <td class="px-1 py-5 text-sm w-2/8">
                                                <div class="flex items-center text-sm">
                                                    <div class="relative w-10 h-10 mr-3 rounded-full md:block">
                                                        @if ($req->user_freelancer->detail_user->photo != null)
                                                            <img class="object-cover w-full h-full rounded-full"
                                                                src="{{ url(Storage::url($req->user_freelancer->detail_user->photo)) }}"
                                                                alt="user photo" loading="lazy" />
                                                        @else
                                                            <img class="object-cover w-full h-full rounded-full"
                                                                src="{{ asset('assets/images/pp.svg') }}"
                                                                alt="Profile Photo">
                                                        @endif
                                                        <div class="absolute inset-0 rounded-full shadow-inner"
                                                            aria-hidden="true">
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <p class="font-medium text-black">{{ $req->user_freelancer->name }}
                                                        </p>
                                                        <p class="text-sm text-gray-400">
                                                            {{ $req->user_freelancer->detail_user->role }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="w-2/6 px-1 py-5">
                                                <div class="flex items-center text-sm">
                                                    <div class="relative w-10 h-10 mr-3 rounded-full md:block">
                                                        @if (isset($req->service->thumbnail_service[0]->thumbnail) && $req->service->thumbnail_service[0]->thumbnail != null)
                                                            <img class="object-cover w-full h-full rounded"
                                                                src="{{ url(Storage::url($req->service->thumbnail_service[0]->thumbnailj)) }}"
                                                                alt="Service Photo">
                                                        @else
                                                            <img class="object-cover w-full h-full rounded"
                                                                src="{{ asset('assets/images/pp.svg') }}"
                                                                alt="Service Photo">
                                                        @endif
                                                        <div class="absolute inset-0 rounded-full shadow-inner"
                                                            aria-hidden="true">
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <p class="font-medium text-black">
                                                            {{ $req->service->title }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-1 py-5 text-sm">
                                                Rp {{ number_format($req->service->price, 0, ',', '.') }}
                                            </td>
                                            <td
                                                class="px-1 py-5 text-sm 
                                                @if ($req->order_status_id == 1) {{ ' text-green-500' }}
                                                @elseif ($req->order_status_id == 2) {{ 'text-yellow-500' }}
                                                @elseif ($req->order_status_id == 3) {{ 'text-red-500' }} @endif text-md">
                                                {{ $req->order_status->name }}
                                            </td>
                                            <td class="px-1 py-5 text-sm">
                                                <a href="{{ route('member.request.show', $req->id) }}"
                                                    class="px-4 py-2 mt-2 text-left text-white rounded-xl bg-serv-email">
                                                    Details
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        {{-- empty --}}
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </main>
                </div>
            </section>
        </main>
    @else
        <div class="flex h-screen">
            <div class="m-auto text-center">
                <img src="{{ asset('/assets/images/empty-illustration.svg') }}" alt="" class="w-48 mx-auto">
                <h2 class="mt-8 mb-1 text-2xl font-semibold text-gray-700">
                    There is No Request Yet
                </h2>
                <p class="text-sm text-gray-400">
                    It seems that you haven’t ordered any service. <br>
                    Let’s order your first service!
                </p>

                <div class="relative mt-0 md:mt-6">
                    <a href="{{ route('explore') }}" class="px-4 py-2 mt-2 text-left text-white rounded-xl bg-serv-button">
                        Find Services
                    </a>
                </div>
            </div>
        </div>
    @endif



@endsection
