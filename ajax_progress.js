(function($) {
    $.fn.ajax_progress = function(options) {
        var settings = $.extend({
            current_item: null,
            total_items: null,
            run: false,
			id: this.attr('id'),
        }, options);

		//insertamos en el elemento seleccionado el html de la barra de progreso
		$(this).append(`
			<label class="progress-label" data-progress-alias="`+settings.id+`">0 de 0 (0%)</label>
			<div class="progress">
				<div data-progress-alias="`+settings.id+`" class="progress-bar `+options.class+` `+(options.striped == true ? ' progress-bar-striped ':'')+`active progress-progressbar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
			</div>
		`);

        function execute_task() {
			console.log(settings.id);
            $.ajax({
                url: options.url,
                type: 'post',
                data: {
                    'current_item': settings.current_item,
                    'total_items': settings.total_items
                },
                success: function(data) {
                    if (data.error == true) {
                        // Manejar el error si es necesario
                    } else {
                        // Mostrar el progreso del proceso
                        let progress = data.progress;
                        let total_items = data.total_items;
                        let current_item = data.current_item;

                        $('.progress-label[data-progress-alias="'+settings.id+'"]').html(current_item + ' de ' + total_items + ' (' + progress + '%)');
                        $('.progress-progressbar[data-progress-alias="'+settings.id+'"]').css('width', progress + '%');

                        if (data.continue == false) {
                            $('.progress-label[data-progress-alias="'+settings.id+'"]').html('Finalizado');
                            $('.progress-progressbar[data-progress-alias="'+settings.id+'"]').css('width', '100%');
							$('[data-target="#'+ settings.id+'"]').text('Iniciar')
							settings.run == false
							//ejectuamos el evento de finalizado
							if (typeof options.onComplete == 'function') {
								options.onComplete();
							}

                        } else {
                            // Continuar el proceso si "continue" es verdadero
                            if (settings.run == true) {
                                settings.current_item = current_item;
                                settings.total_items = total_items;
                                execute_task();
                            }
                        }
                    }
                },
                error: function(data) {
                    $('.progress-label[data-progress-alias="'+settings.id+'"]').html('Error').addClass('text-danger');
					$('[data-target="#'+settings.id+'"]').text('Reintentar')
                }
            });
        }

		//click en el .progress-button
		
		$('[data-target="#'+settings.id+'"]').click( function() {
			// console.log('Se ha hecho click en el botón' + settings.id);
			// console.log('Se ha hecho click cuando el estado estaba en ' + settings.run);
			if (settings.run == false) {
				settings.run = true;
				// console.log('Se ha cambiado el estado a true');
				$('[data-target="#'+settings.id+'"]').text('Detener');
				execute_task();
			} else {
				settings.run = false;
				// console.log('Se ha cambiado el estado a false');
				$('[data-target="#'+ settings.id+'"]').text('Continuar'); // Cambiar el texto del botón a "Iniciar"
			}
		});
    };
})(jQuery);