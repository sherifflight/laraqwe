<script>

    $(document).ready(function() {

        var $rolesSelect = $('select#rolesSelect'),
            $permissionBlocks = $("div[id^='permissionBlock']"),
            $storesSelect = $('select#storesSelect'),
            $allStoresCheckbox = $('input#checkboxAllStores'),
            $clearStoresCheckbox = $('input#checkboxClearStores'),
            $citiesSelect = $('select#citiesSelect'),
            $allCitiesCheckbox = $('input#checkboxAllCities'),
            $clearCitiesCheckbox = $('input#checkboxClearCities'),
            $vendorsSelect = $('select#vendorsSelect'),
            $allVendorsCheckbox = $('input#checkboxAllVendors'),
            $clearVendorsCheckbox = $('input#checkboxClearVendors');

        function togglePermissionBlocks()
        {
            $permissionBlocks.hide();
            if ($rolesSelect.val() && $rolesSelect.val().length > 0) {
                var $block = $permissionBlocks.filter('#permissionBlock' + $rolesSelect.val());
                if ($block.length > 0) {
                    $block.show();
                }
            }
        }

        function toggleClear(clear = true, $select, $allCheckbox)
        {
            if (clear) {
                $select.find('option').prop('selected', false);
                $select.trigger('change');
                $allCheckbox.prop('checked', false);
            }
        }

        function toggleAllSelected(selected = true, $select, $clearCheckbox)
        {
            if (selected) {
                $select.find('option').prop('selected', true);
                $select.trigger('change');
                $clearCheckbox.prop('checked', false);
            }
        }

        function actualizeClearAllChekboxes($select, $allCheckbox, $clearCheckbox)
        {
            var $selectedOptions = $select.find('option:selected'),
                $allOptions = $storesSelect.find('option');
            if ($selectedOptions.length == 0) {
                $allCheckbox.prop('checked', false);
                $clearCheckbox.prop('checked', true);
            } else if ($allOptions.length == $selectedOptions.length) {
                $allCheckbox.prop('checked', true);
                $clearCheckbox.prop('checked', false);
            } else {
                $allCheckbox.prop('checked', false);
                $clearCheckbox.prop('checked', false);
            }
        }

        function fillStoresSelect(vendorIds)
        {
            $storesSelect.prop('disabled', true);
            $storesSelect.val('');
            $storesSelect.empty();

            var selected = (
                $storesSelect.data('selected') && $storesSelect.data('selected').length > 0
                    ? $storesSelect.data('selected')
                    : ''
            );

            $.post(route('dashboard.users.storesSelect'),
                {
                    vendorIds : vendorIds,
                    selected : selected
                },
                function(data, status, xhr) {
                    if (data.success && data.data.length > 0) {
                        $storesSelect.append(data.data).prop('disabled', false).trigger('change');
                    } else {
                        console.log('Stores cannot be loaded.');
                    }
                }, 'json');
        }

        togglePermissionBlocks();
        $rolesSelect.change(function () {
            togglePermissionBlocks();
        });

        fillStoresSelect($vendorsSelect.val());
        $vendorsSelect.change(function () {
            fillStoresSelect($(this).val());
        });

        actualizeClearAllChekboxes($storesSelect, $allStoresCheckbox, $clearStoresCheckbox);
        $storesSelect.change(function () {
            actualizeClearAllChekboxes($storesSelect, $allStoresCheckbox, $clearStoresCheckbox);
        });
        $allStoresCheckbox.change(function () {
            toggleAllSelected($(this).is(':checked'), $storesSelect, $clearStoresCheckbox);
        });
        $clearStoresCheckbox.change(function () {
            toggleClear($(this).is(':checked'), $storesSelect, $allStoresCheckbox);
        });

        actualizeClearAllChekboxes($citiesSelect, $allCitiesCheckbox, $clearCitiesCheckbox);
        $citiesSelect.change(function () {
            actualizeClearAllChekboxes($citiesSelect, $allCitiesCheckbox, $clearCitiesCheckbox);
        });
        $allCitiesCheckbox.change(function () {
            toggleAllSelected($(this).is(':checked'), $citiesSelect, $clearCitiesCheckbox);
        });
        $clearCitiesCheckbox.change(function () {
            toggleClear($(this).is(':checked'), $citiesSelect, $allCitiesCheckbox);
        });

        actualizeClearAllChekboxes($vendorsSelect, $allVendorsCheckbox, $clearVendorsCheckbox);
        $vendorsSelect.change(function () {
            actualizeClearAllChekboxes($vendorsSelect, $allVendorsCheckbox, $clearVendorsCheckbox);
        });
        $allVendorsCheckbox.change(function () {
            toggleAllSelected($(this).is(':checked'), $vendorsSelect, $clearVendorsCheckbox);
        });
        $clearVendorsCheckbox.change(function () {
            toggleClear($(this).is(':checked'), $vendorsSelect, $allVendorsCheckbox);
        });
    });

</script>
