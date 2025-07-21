  @foreach ($section['fields'] as $field)
      <div class="col-span-2 md:col-span-1">
          <label for="{{ $field['id'] }}" class="md:text-lg font-medium block mb-4">
              {{ $field['label'] }}
              @if (!empty($field['required']))
                  <span class="text-red-500">*</span>
              @endif
          </label>

          @if ($field['type'] === 'textarea')
              <textarea id="{{ $field['id'] }}" name="{{ $field['name'] }}" rows="4" {{ isset($show) && $show ? 'readonly' : '' }}
                  class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 resize-none"
                  placeholder="Enter {{ strtolower($field['label']) }}" readonly>{{ old($field['name'], $company->{$field['name']} ?? '') }}</textarea>
          @elseif ($field['type'] === 'date')
              <input type="date" id="{{ $field['id'] }}" name="{{ $field['name'] }}"
                  class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                  value="{{ old($field['name'], $company->{$field['name']} ?? '') }}"
                  {{ isset($show) && $show ? 'readonly' : '' }} />
          @elseif ($field['type'] === 'number')
              <input type="number" id="{{ $field['id'] }}" name="{{ $field['name'] }}"
                  class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                  placeholder="Enter {{ strtolower($field['label']) }}"
                  value="{{ old($field['name'], $company->{$field['name']} ?? '') }}"
                  {{ isset($show) && $show ? 'readonly' : '' }} />
          @else
              <input type="{{ $field['type'] }}" id="{{ $field['id'] }}" name="{{ $field['name'] }}"
                  class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                  placeholder="Enter {{ strtolower($field['label']) }}"
                  value="{{ old($field['name'], $company->{$field['name']} ?? '') }}"
                  {{ isset($show) && $show ? 'readonly' : '' }} />
          @endif
      </div>
  @endforeach
