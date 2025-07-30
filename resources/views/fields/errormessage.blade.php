      @if (session('success'))
          <div id="success-alert"
              style="background-color: #d4edda; border: 1px solid #28a745; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 10px; position: relative;">
              <strong>Success:</strong> {{ session('success') }}
              <span onclick="document.getElementById('success-alert').style.display='none';"
                  style="position: absolute; top: 5px; right: 10px; cursor: pointer; color: #155724;">&times;</span>
          </div>
      @endif

      @if (session('error'))
          <div id="error-alert"
              style="background-color: #f8d7da; border: 1px solid #dc3545; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 10px; position: relative;">
              <strong>Error:</strong> {{ session('error') }}
              <span onclick="document.getElementById('error-alert').style.display='none';"
                  style="position: absolute; top: 5px; right: 10px; cursor: pointer; color: #721c24;">&times;</span>
          </div>
      @endif
