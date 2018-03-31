/* Envoie la saisie en recherche sql */
    $(document).ready(function () {
		
		/* Contrôle la searchbox en fonction du checkbox choisit avec datepicker actif juste pour le checkbox date */
		var category = "nom";
		var query = "";
		$("input[name=category]").change(function(){
			if($(this).is(":checked")) {
				category = $(this).val();
				
				/* Si date séléctionné, on active le datepicker */
				if(category === "date"){
					$( ".typeahead" ).attr("id", "datepicker");
					$( "#datepicker" ).datepicker({
						beforeShow: function (input, inst) {
							setTimeout(function () {
								inst.dpDiv.css({
									top: 20,
									left: 520
								});
							}, 0);
						}
					});
					$( "#datepicker" ).datepicker();
					$( "#datepicker" ).datepicker( $.datepicker.regional[ "fr" ] );
					
				}
				
				/* Si autre séléctionné, on désactive datepicker */
				if(category !== "date"){
				
					if (document.getElementById("datepicker") !== null){
						
						$( "#datepicker" ).datepicker("destroy");
						$( "#datepicker").removeClass("hasDatepicker");
						
						document.getElementById("datepicker").id = "searchbox";
						$( "#ui-datepicker-div" ).remove();
					}
				
				}
				
				/* On vide la searchbox */
				if ($("input[name=searchbox]").val()) {
					$("input[name=searchbox]").val("");
				}
			}
		});
		
		$("input[name=searchbox]").change(function(){
			var text = $("input[name=searchbox]").val();
			query += text;
			// String.prototype.sansAccent = function(){
				// var accent = [
					// /[\300-\306]/g, /[\340-\346]/g, // A, a
					// /[\310-\313]/g, /[\350-\353]/g, // E, e
					// /[\314-\317]/g, /[\354-\357]/g, // I, i
					// /[\322-\330]/g, /[\362-\370]/g, // O, o
					// /[\331-\334]/g, /[\371-\374]/g, // U, u
					// /[\321]/g, /[\361]/g, // N, n
					// /[\307]/g, /[\347]/g, // C, c
				// ];
				// var noaccent = ['A','a','E','e','I','i','O','o','U','u','N','n','C','c'];
     
				// var str = this;
				// for(var i = 0; i < accent.length; i++){
					// str = str.replace(noaccent[i], accent[i]);
				// }
     
				// return str;
			// }
			// query = query.sansAccent();
			// console.log(query);
		})
		var id = document.getElementById("searchbox");
        $(id).typeahead({
            source: function (query, result) {
				console.log(result);
                $.ajax({
                    url: "searchengine.php",
					data: "query=" +  query + "&category=" + category,
                    dataType: "json",
                    type: "POST",
                    success: function (data) {
						console.log(data);
						result($.map(data, function (item) {
							return item;
                        }));
                    }
                });
            }
        });
    });