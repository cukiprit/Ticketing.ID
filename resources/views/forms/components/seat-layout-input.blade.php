<x-dynamic-component
    :component="$getFieldWrapperView()"
    :id="$getId()"
    :label="$getLabel()"
    :label-sr-only="$isLabelHidden()"
    :helper-text="$getHelperText()"
    :hint="$getHint()"
    :hint-action="$getHintAction()"
    :hint-color="$getHintColor()"
    :hint-icon="$getHintIcon()"
    :required="$isRequired()"
    :state-path="$getStatePath()"
>
    <div x-data="
        { state: $wire.entangle('{{ $getStatePath() }}').defer },
        seats: @js($getSeatData() ?: [
            ['id' => 'A1', 'price' => 100, 'status' => 'available'],
            ['id' => 'A2', 'price' => 100, 'status' => 'available']
        ]),
        newSeatPrice: 100,
        addRow() {
            const lastRow = this.seats.length > 0
                ? this.seats[this.seats.length - 1].id.charCodeAt(0)
                : 64;
            const rowLetter = String.fromCharCode(lastRow + 1);

            for (let i = 1; i <= 5; i++) {
                this.seats.push({
                    id: `${rowLetter}${i}`,
                    price: this.newSeatPrice,
                    status: 'available'
                });
            }
        },
        toggleSeat(seat) {
            seat.status = seat.status === 'available' ? 'selected' : 'available';
        }
        ">
        <div class="flex gap-4 mb-4">
            <button type="button" @click="addRow" class="px-3 py-1 bg-gray-100 rounded">
                Add Row
            </button>
            <input x-model="newSeatPrice" type="number" class="border rounded px-2 w-24">
        </div>

        <div class="flex flex-wrap gap-2">
            <template x-for="seat in seats" :key="seat.id">
                <div
                    :x-text="seat.id"
                    @click="toggleSeat"
                    class="w-10 h-10 flex items-center justify-center border rounded cursor-pointer"
                    :class="{
                        'bg-green-200': seat.status === 'available',
                        'bg-red-200': seat.status !== 'available'
                    }"
                ></div>
            </template>
        </div>

        <input type="hidden" name="{{ $getName() }}" x-model="JSON.stringify(seats)">
        <!-- Interact with the `state` property in Alpine.js -->
    </div>
</x-dynamic-component>
