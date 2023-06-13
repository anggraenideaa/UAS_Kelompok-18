
    function tambahItem() {
      var orderItemsContainer = document.getElementById('orderItemsContainer');

      var div = document.createElement('div');
      div.classList.add('mb-3');

      var menuSelect = document.createElement('select');
      menuSelect.classList.add('form-select');
      menuSelect.setAttribute('name', 'menu[]');
      menuSelect.setAttribute('required', '');

      var options = <?php echo json_encode($menuOptions); ?>; // Menggunakan variabel $menuOptions yang telah diisi sebelumnya

      options.forEach(function(option) {
        var optionElement = document.createElement('option');
        optionElement.value = option.id;
        optionElement.text = option.nama_menu;
        menuSelect.appendChild(optionElement);
      });

      div.appendChild(menuSelect);

      var quantityInput = document.createElement('input');
      quantityInput.setAttribute('type', 'number');
      quantityInput.classList.add('form-control');
      quantityInput.setAttribute('name', 'quantity[]');
      quantityInput.setAttribute('required', '');

      div.appendChild(quantityInput);

      orderItemsContainer.appendChild(div);
    }

    // Menghitung total pembayaran saat memilih menu dan jumlah
    function hitungTotal() {
      var totalAmountInput = document.getElementById('totalAmount');
      var menuSelects = document.querySelectorAll('select[name="menu[]"]');
      var quantityInputs = document.querySelectorAll('input[name="quantity[]"]');

      var total = 0;

      for (var i = 0; i < menuSelects.length; i++) {
        var menuId = menuSelects[i].value;
        var quantity = parseInt(quantityInputs[i].value);
        var hargaMenu = 0; // Nilai awal harga menu

        // Cari harga menu berdasarkan menuId
        <?php
          mysqli_data_seek($result, 0);
          while ($row = mysqli_fetch_assoc($result)) {
            echo 'if (menuId === "' . $row['id'] . '") {';
            echo 'hargaMenu = ' . $row['harga_menu'] . ';';
            echo '}';
          }
        ?>

        total += hargaMenu * quantity;
      }

      totalAmountInput.value = total.toFixed(2);
    }

    // Panggil fungsi hitungTotal saat ada perubahan pada pilihan menu atau jumlah
    var menuSelects = document.querySelectorAll('select[name="menu[]"]');
    var quantityInputs = document.querySelectorAll('input[name="quantity[]"]');

    for (var i = 0; i < menuSelects.length; i++) {
      menuSelects[i].addEventListener('change', hitungTotal);
      quantityInputs[i].addEventListener('change', hitungTotal);
    }