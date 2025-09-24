  @php
  $sections = config('promoter_form');
  @endphp
  @extends('layout.main')
  @section('page-title', isset($promoter) ? (!empty($show) ? 'VIEW ' . $promoter->first_name . ' PROMOTER' : 'EDIT ' .
  $promoter->first_name . ' PROMOTER') : 'ADD PROMOTER')

  @push('style')
  <style>
      .switch {
          position: relative;
          display: inline-block;
          width: 60px;
          height: 30px;
      }

      .switch input {
          opacity: 0;
          width: 0;
          height: 0;
      }

      .slider {
          position: absolute;
          cursor: pointer;
          top: 0;
          left: 0;
          right: 0;
          bottom: 0;
          background-color: #ccc;
          transition: .4s;
          border-radius: 30px;
          text-align: center;
          line-height: 30px;
          font-size: 12px;
          font-weight: bold;
          color: white;
      }

      .slider:before {
          position: absolute;
          content: "";
          height: 22px;
          width: 22px;
          left: 4px;
          bottom: 4px;
          background-color: white;
          transition: .4s;
          border-radius: 50%;
      }

      input:checked+.slider {
          background-color: #4CAF50;
      }

      input:checked+.slider:before {
          transform: translateX(30px);
      }

      .slider .switch-on,
      .slider .switch-off {
          position: absolute;
          top: 0;
          bottom: 0;
          width: 50%;
          display: flex;
          align-items: center;
          justify-content: center;
      }

      .slider .switch-on {
          left: 0;
          font-size: 12px;

      }

      .slider .switch-off {
          right: 0;
          font-size: 12px;

      }
  </style>
  @endpush

  @section('content')

  <head>
      <style>
          input[type="radio"] {

              width: 24px;

              height: 24px;

              accent-color: green;

          }
      </style>
  </head>
  @include('fields.errormessage')

  <div class="box mb-4 xxxl:mb-6">
      <form id="companyForm" action="{{ $route }}" method="POST" class="grid grid-cols-2 gap-4 xxxl:gap-6">
          @csrf
          @if ($method == 'PUT')
          @method('PUT')
          @endif

          @foreach ($sections as $sectionName => $fields)
          @php
          $cleanSectionName = trim($sectionName ?? '');
          $formattedSectionName = $cleanSectionName
          ? ucwords(str_replace('_', ' ', $cleanSectionName))
          : '';
          @endphp

          @if ($sectionName)
          <div class="col-span-2">
              <h4
                  class="pb-4 mb-4 bb-dashed md:mb-6 md:pb-6 font-semibold text-center text-gray-800  capitalize">
                  {{ $formattedSectionName }}
              </h4>
          </div>
          @endif
          @foreach ($fields as $field)
          @php
          $name = $field['name'];
          $type = $field['type'] ?? 'text';
          $label = $field['label'];
          $id = $field['id'] ?? $name;
          $required = $field['required'] ?? false;

          // Extract nominee field name by removing 'nominee_' prefix:
          $nomineeField = null;
          if (str_starts_with($name, 'nominee_')) {
          $nomineeField = substr($name, strlen('nominee_')); // e.g. 'name', 'relation'
          }

          if (
          isset($promoter?->kyc) &&
          in_array($name, [
          'aadhaar_no',
          'voter_id_no',
          'pan_no',
          'ration_card_no',
          'meter_no',
          'ci_no',
          'ci_relation',
          'dl_no',
          ])
          ) {
          $value = old($name, $promoter?->kyc?->$name ?? ($field['default'] ?? ''));
          } elseif (
          $nomineeField !== null &&
          $promoter?->nominees?->isNotEmpty() &&
          in_array($nomineeField, [
          'name',
          'relation',
          'mobile_no',
          'aadhaar_no',
          'voter_id_no',
          'pan_no',
          'address',
          ])
          ) {
          $firstNominee = $promoter?->nominees?->first();
          $value = old($name, $firstNominee?->$nomineeField ?? ($field['default'] ?? ''));
          } elseif ($name === 'enrollment_date' || $name === 'date_of_birth') {
          $value = old(
          $name,
          $promoter?->$name instanceof \Carbon\Carbon
          ? $promoter?->$name->format('d-m-Y')
          : $promoter?->$name ?? ($field['default'] ?? ''),
          );
          } else {
          $value = old($name, $promoter?->$name ?? ($field['default'] ?? ''));
          }
          @endphp

          <div class="col-span-2 md:col-span-1">
              @include('fields.label', [
              'id' => $id,
              'label' => $label,
              'required' => $required,
              ])

              @include('fields.inputs', [
              'id' => $id,
              'label' => $label,
              'required' => $required,
              'type' => $type,
              'name' => $name,
              'value' => $value,
              'readonly' => empty($show) ? '' : 'readonly',
              'field' => $field,
              ])

              @error($name)
              <span class="text-red-500 text-xs block mt-1">{{ $message }}</span>
              @enderror
          </div>
          @endforeach
          @endforeach
          <div class="col-span-2 flex gap-4 md:gap-6 mt-4">
              @if (empty($show))
              <button class="btn-primary" type="submit">
                  {{ $method === 'PUT' ? 'Update' : 'Save' }} Promoter
              </button>
              @endif
              <a href="{{ route('promotor.index') }}" class="btn-outline inline-flex items-center justify-center">
                  Back
              </a>
              @if ($method === 'POST')
              <button class="btn-outline" type="reset" onclick="document.getElementById('companyForm').reset();">
                  Reset
              </button>
              @endif

          </div>
      </form>
  </div>
  <script>
      document.addEventListener('DOMContentLoaded', function() {
          const titleSelect = document.querySelector('select[name="title"]');
          const genderRadios = document.querySelectorAll('input[name="gender"]');

          if (titleSelect) {
              titleSelect.addEventListener('change', function() {
                  const selectedTitle = this.value;
                  let genderToSelect = '';

                  if (selectedTitle === 'MD' || selectedTitle === 'Mr') {
                      genderToSelect = 'Male';
                  } else if (selectedTitle === 'Ms' || selectedTitle === 'Mrs') {
                      genderToSelect = 'Female';
                  } else {
                      genderToSelect = '';
                  }

                  genderRadios.forEach(radio => {
                      radio.checked = (radio.value === genderToSelect);
                  });
              });
          }
      });
  </script>
  @endsection
  @push('script')
  <script>
      document.addEventListener('DOMContentLoaded', () => {
          const applyDigitValidation = (id, maxLength, exactLength = false) => {
              const input = document.getElementById(id);
              if (!input) return;

              input.addEventListener('input', () => {
                  input.value = input.value.replace(/\D/g, '').slice(0, maxLength);
              });

              if (exactLength) {
                  input.addEventListener('blur', () => {
                      if (input.value.length !== maxLength) {
                          alert(`${formatLabel(id)} must be exactly ${maxLength} digits.`);
                          input.focus();
                      }
                  });
              }
          };

          const applyPANValidation = (id) => {
              const input = document.getElementById(id);
              if (!input) return;

              const panRegex = /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/;

              input.addEventListener('input', () => {
                  input.value = input.value.toUpperCase().replace(/[^A-Z0-9]/g, '').slice(0, 10);
              });
          };

          const applyAlphaNumValidation = (id, maxLength = null) => {
              const input = document.getElementById(id);
              if (!input) return;

              input.addEventListener('input', () => {
                  input.value = input.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
                  if (maxLength) {
                      input.value = input.value.slice(0, maxLength);
                  }
              });
          };

          const formatLabel = (id) =>
              id.replace(/_/g, ' ').replace(/\b\w/g, (c) => c.toUpperCase());

          // Mobile Numbers (10 digits)
          ['mobile', 'nominee_mobile_no'].forEach(id => applyDigitValidation(id, 10));

          // Aadhaar Numbers (12 digits exactly)
          applyDigitValidation('aadhaar_no', 12, true);
          applyDigitValidation('nominee_aadhaar_no', 12, true);

          // PAN Numbers (Format: AAAAA9999A)
          applyPANValidation('pan_no');
          applyPANValidation('nominee_pan_no');

          // Voter ID (alphanumeric, max 10)
          applyAlphaNumValidation('voter_id_no', 10);

          // Ration Card No. (alphanumeric, max 16)
          applyAlphaNumValidation('ration_card_no', 16);
      });
  </script>

  @endpush