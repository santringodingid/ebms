<script>
	toastr.options = {
		"positionClass": "toast-top-center",
		"timeOut": "2000"
	}

	$(function() {
		accounts()
	})

	let modalElement = $('#modal-account')
	let categoryElement = $('#category')
	let nameElement = $('#name')

	modalElement.on('hidden.bs.modal', () => {
		nameElement.val('')
		categoryElement.val('')
		$('.form-control-border').removeClass('is-invalid')
		$('.errors').html('')
	})

	$('#save-account').on('click', function() {
		$.ajax({
			url: '<?= base_url() ?>account/save',
			method: 'post',
			data: {
				category: categoryElement.val(),
				name: nameElement.val()
			},
			dataType: 'JSON',
			beforeSend: function() {
				$('#save-account').prop('disabled', true)
			},
			success: function(response) {
				$('#save-account').prop('disabled', false)
				let status = response.status
				if (status == 400) {
					let errors = response.errors
					if (errors.category) {
						$('#error-category').html(errors.category)
						$('#category').addClass('is-invalid')
					}else {
						$('#error-category').html('')
						$('#category').removeClass('is-invalid')
					}

					if (errors.name) {
						$('#error-name').html(errors.name)
						$('#name').addClass('is-invalid')
					}else {
						$('#error-name').html('')
						$('#name').removeClass('is-invalid')
					}
					return false
				}

				if (status == 500) {
					toastr.error(`Opsss.! ${response.message}`)
					return false
				}

				$('.errors').html('')
				$('.form-control-border').removeClass('is-invalid')
				categoryElement.val('')
				nameElement.val('');
				accounts()

				toastr.success('Yeaah, satu akun berhasil ditambahkan')
			}
		})
	})

	const accounts = () => {
		let category = $('#change-category').val()
		$.ajax({
			url: '<?= base_url() ?>account/accounts',
			data: {
				category
			},
			method: 'POST',
			success: response => {
				$('#show-account').html(response)
			}
		})
	}

</script>
