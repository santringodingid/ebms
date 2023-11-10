<script>
    $('[data-mask]').inputmask();

    toastr.options = {
        "positionClass": "toast-top-center",
        "timeOut": "2000"
    }

    const errorAlert = message => {
        toastr.error(`Opss.! ${ message }`)
    }

	let reservation = $('#reservation')

	reservation.daterangepicker({
		ranges: {
			'Hari ini': [moment(), moment()],
			'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
			'7 hari terakhir': [moment().subtract(6, 'days'), moment()],
			'30 hari terakhir': [moment().subtract(29, 'days'), moment()],
			'Bulan ini': [moment().startOf('month'), moment().endOf('month')],
			'Bulan lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
		},
		autoUpdateInput: false,
		locale: {
			cancelLabel: 'Reset',
			applyLabel: 'Terapkan'
		}
	})

	reservation.on('apply.daterangepicker', function(ev, picker) {
		$(this).val('').attr('placeholder', picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
		$('#start').val(picker.startDate.format('YYYY-MM-DD'))
		$('#end').val(picker.endDate.format('YYYY-MM-DD'))
		cashFlows()
	});

	reservation.on('cancel.daterangepicker', function(ev, picker) {
		$(this).attr('placeholder', 'Semua waktu').val('');
		$('#start').val('')
		$('#end').val('')
		cashFlows()
	});

	$('#account').on('change', function (){
		$('#account-selected').val($(this).val())
	})

    $(function(){
		$('#account-selected').val($('#account').val())
		cashFlows()
    })

    const cashFlows = () => {
		let account = $('#account').val()
        let start = $('#start').val()
		let end = $('#end').val()

        $.ajax({
            url: '<?= base_url() ?>report/cashFlows',
            method: 'POST',
            data: {
				account,
                start,
                end
            },
            success: function(res) {
                $('#show-data').html(res)
            }
        })
    }

</script>
</body>

</html>
