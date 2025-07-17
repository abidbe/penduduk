<div class="card bg-base-100 shadow-lg">
    <div class="card-body">
        <!-- Title -->
        <div class="flex w-full justify-center mb-6">
            <h2 class="text-3xl card-title">{{ $title }}</h2>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="table table-zebra w-full">
                <thead>
                    <tr>
                        {{ $headers }}
                    </tr>
                </thead>
                <tbody id="{{ $tableId }}">
                    {{ $rows }}
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex justify-end mt-6">
            <div class="join">
                <button class="join-item btn" id="prevBtn" onclick="pagination.prev()">«</button>
                <button class="join-item btn" id="pageInfo">Page 1</button>
                <button class="join-item btn" id="nextBtn" onclick="pagination.next()">»</button>
            </div>
        </div>
    </div>
</div>
