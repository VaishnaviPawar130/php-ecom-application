<div id="productModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 px-4">
    <div class="relative w-full max-w-4xl rounded-[28px] bg-white shadow-2xl">

        <button id="closeModal"
            class="absolute right-4 top-4 z-10 flex h-10 w-10 items-center justify-center rounded-full bg-slate-100 text-xl font-bold text-slate-700 hover:bg-slate-200">
            ×
        </button>

        <div class="grid md:grid-cols-2">
            <div class="flex items-center justify-center rounded-l-[28px] bg-slate-100 p-6">
                <img id="modalImage" src="" alt="Product Image" class="max-h-[420px] w-auto max-w-full object-contain">
            </div>

            <div class="p-8">
                <p id="modalBrand" class="text-xs font-semibold uppercase tracking-[0.18em] text-blue-600"></p>

                <h2 id="modalName" class="mt-2 text-3xl font-bold text-slate-900"></h2>

                <div class="mt-3 flex flex-wrap items-center gap-3">
                    <span id="modalCategory"
                        class="rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700"></span>
                    <span id="modalStock" class="rounded-full px-3 py-1 text-xs font-semibold"></span>
                </div>

                <div class="mt-5">
                    <p class="text-sm text-slate-500">Price</p>
                    <p id="modalPrice" class="mt-1 text-3xl font-bold text-slate-900"></p>
                </div>

                <div class="mt-6">
                    <p class="text-sm font-semibold text-slate-900">Description</p>
                    <p id="modalDescription" class="mt-2 text-sm leading-7 text-slate-600"></p>
                </div>

                <div class="mt-8 flex gap-3">
                    <button
                        class="rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-700 transition">
                        Add to Cart
                    </button>
                    <button id="closeModalBtn"
                        class="rounded-xl border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-100 transition">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>