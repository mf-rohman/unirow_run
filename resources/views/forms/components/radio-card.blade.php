<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div x-data="{ state: $wire.$entangle('{{ $getStatePath() }}') }">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-2">
            @foreach ($getOptions() as $value => $label)
                <label class="cursor-pointer relative">
                    <input type="radio" value="{{ $value }}" x-model="state" class="peer sr-only">
                    
                    <div class="p-6 bg-white rounded-xl shadow-md text-center transition-all duration-200 border-2 border-transparent 
                                peer-checked:border-blue-500 peer-checked:ring-4 peer-checked:ring-blue-500/20 peer-checked:scale-105
                                hover:shadow-lg hover:-translate-y-1">
                        
                        <div class="text-4xl mb-3">
                            {!! $getDescriptions()[$value] ?? '🏃' !!}
                        </div>

                        <span class="block text-lg font-bold text-gray-800">
                            {{ $label }}
                        </span>
                        
                        <div class="absolute top-3 right-3 opacity-0 peer-checked:opacity-100 text-blue-500 transition-opacity">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        </div>
                    </div>
                </label>
            @endforeach
        </div>
    </div>
</x-dynamic-component>