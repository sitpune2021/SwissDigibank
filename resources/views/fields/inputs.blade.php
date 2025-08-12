@if ($type === 'textarea')
    <textarea id="{{ $id }}" name="{{ $name }}" rows="4"
        class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 resize-none"
        placeholder="Enter {{ strtolower($label) }}" >{{ $value }}</textarea>
@elseif ($type === 'date')
    <input type="date" id="{{ $id }}" name="{{ $name }}"
        class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
        value="{{ $value }}"  />
@elseif ($type === 'number')
    <input type="number" id="{{ $id }}" name="{{ $name }}"
        class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
        placeholder="Enter {{ strtolower($label) }}" value="{{ $value }}"  />
@elseif ($type === 'select')
    <select name="{{ $name }}" id="{{ $id }}"
        class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
        {{ empty($show) ? '' : 'disabled' }}>

        <option value="">-- Select {{ $label }} --</option>
        @if (!empty($field['dynamic']) && !empty($field['options_key']) && isset($dynamicOptions[$field['options_key']]))
            @foreach ($dynamicOptions[$field['options_key']] as $optionValue => $optionLabel)
                <option value="{{ $optionValue }}" {{ $value == $optionValue ? 'selected' : '' }}>
                    <!-- {{ $optionValue }}{{ $value }} -->
                    {{ $optionLabel }}
                </option>
            @endforeach
        @elseif(!empty($field['options']))
            @foreach ($field['options'] as $optionValue => $optionLabel)
                <option value="{{ $optionValue }}" {{ $value == $optionValue ? 'selected' : '' }}>
                    {{ $optionLabel }}
                </option>
            @endforeach
        @endif
    </select>
@elseif ($type === 'radio')
    <div class="flex gap-4">
        @foreach ($field['options'] as $optionValue => $optionLabel)
            <div class="flex items-center relative"><input id="{{ $id }}" class="opacity-0 absolute h-8 w-8"
                    type="radio" name="{{ $name }}" value="{{ $optionValue }}" name="A3-confirmation" {{ $value == $optionValue ? 'checked' : '' }}>
                <div
                    class="bg-n0 dark:bg-bg4 border border-gray-400 rounded-full w-5 h-5 flex shrink-0 justify-center items-center ltr:mr-2 rtl:ml-2 focus-within:border-primary">
                    <svg class="fill-current hidden w-[10px] h-[10px] text-primary pointer-events-none" version="1.1"
                        viewBox="0 0 17 12" xmlns="http://www.w3.org/2000/svg">
                        <g fill="none" fill-rule="evenodd">
                            <g transform="translate(-9 -11)" fill="#20B757" fill-rule="nonzero">
                                <path
                                    d="m25.576 11.414c0.56558 0.55188 0.56558 1.4439 0 1.9961l-9.404 9.176c-0.28213 0.27529-0.65247 0.41385-1.0228 0.41385-0.37034 0-0.74068-0.13855-1.0228-0.41385l-4.7019-4.588c-0.56584-0.55188-0.56584-1.4442 0-1.9961 0.56558-0.55214 1.4798-0.55214 2.0456 0l3.679 3.5899 8.3812-8.1779c0.56558-0.55214 1.4798-0.55214 2.0456 0z">
                                </path>
                            </g>
                        </g>
                    </svg>
                </div><label for="{{ $id }}"
                    class="select-none text-sm md:text-base flex gap-2 cursor-pointer items-center">{{ $optionLabel }}</label>
            </div>
        @endforeach
    </div>
@elseif ($type === 'checkbox')
    <label class="switch">
        <input type="checkbox" name="{{ $name }}" id="{{ $id }}" value="1"
            {{ $value ? 'checked' : '' }}{{ isset($show) ? 'disabled' : '' }}>
        <div class="slider round">
            <span class="switch-on">ON</span>
            <span class="switch-off">OFF</span>
        </div>
    </label>
@else
    <input type="{{ $type }}" id="{{ $id }}" name="{{ $name }}"
        class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
        placeholder="Enter {{ strtolower($label) }}" value="{{ $value }}"  />
@endif
