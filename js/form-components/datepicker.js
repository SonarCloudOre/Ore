// Forms Datepicker

$(document).ready(() => {
    // Datepicker


    $("input[name='dateAppel']").datepicker({
        format: 'dd/mm/yyyy',
        days: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
        daysShort: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
        daysMin: ['Di', 'Lu', 'Ma', 'Me', 'Je', 'Ve', 'Sa'],
        weekStart: 1,
        months: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
        monthsShort: ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Jun', 'Jui', 'Aoû', 'Sep', 'Oct', 'Nov', 'Dec']
    });
    /*
          $("input[name='dateAppel']").on("change",function(){
              var selected = $(this).val();
              var date = new Date(selected);
              var inJour = date.getDay(); // on récupère le jour de la semaine, utilisation de getMonth car la date est au format 'dd-mm-yyyy', sinon, on aurait utiliser getDay();
              alert(selected);
              if (inJour !=3  && inJour != 6)
              {var valider = confirm("etes vous sur!");
              if (valider == true) {
              } else {
                $("input[name='dateAppel']").val('');
              }
            }
            else {
            }
          });

    */

 


    $('[data-toggle="datepicker"]').datepicker({
        format: 'yyyy-mm-dd'
    });
    $('[data-toggle="datepicker-year"]').datepicker({
        startView: 2,
    });

    $('[data-toggle="datepicker-month"]').datepicker({
        startView: 1,
    });

    $('[data-toggle="datepicker-inline"]').datepicker({
        inline: true,
    });

    $('[data-toggle="datepicker-icon"]').datepicker({
        trigger: ".datepicker-trigger",
    });

    $('[data-toggle="datepicker-button"]').datepicker({
        trigger: ".datepicker-trigger-btn",
    });

    // Daterangepicker

    $('input[name="daterange"]').daterangepicker({
        singleDatePicker: true,
        timePicker: true,
    });

    $('input[name="datetimes"]').daterangepicker({
        timePicker: true,
        startDate: moment().startOf("hour"),
        endDate: moment().startOf("hour").add(32, "hour"),
        locale: {
            format: "M/DD hh:mm A",
        },
    });

    $('input[name="birthday"]').daterangepicker(
        {
            singleDatePicker: true,
            showDropdowns: true,
            minYear: 1901,
            maxYear: parseInt(moment().format("YYYY"), 10),
        },
        function (start, end, label) {
            var years = moment().diff(start, "years");
            alert("You are " + years + " years old!");
        }
    );

    var start = 0;
    var end = 0;

    function cb(start, end) {
        if (start !== 0) {
            $("#reportrange span").html(
                start.format("DD-MM-Y") + " -> " + end.format("DD-MM-Y"));
            $("#reportrange2 span").html(
                start.format("DD-MM-Y") + " -> " + end.format("DD-MM-Y"));
            $('#from').val(start.format('Y-MM-DD'));
            $('#to').val(end.format('Y-MM-DD'));
            $('#from2').val(start.format('Y-MM-DD'));
            $('#to2').val(end.format('Y-MM-DD'));

        } else {
            $("#reportrange span").html(
                "Choisir une date"
            );
            $("#reportrange2 span").html(
                "Choisir une date"
            );
        }

    }

    moment.locale('fr');
    $("#reportrange").daterangepicker(
        {
            startDate: start,
            endDate: end,
            opens: "right",
            ranges: {
                "Hier": [moment().subtract(1, "days"), moment().subtract(1, "days")],
                "Dernière semaine": [moment().subtract(6, "days"), moment()],
                "30 derniers jours": [moment().subtract(29, "days"), moment()],
                "Ce mois-ci": [moment().startOf("month"), moment().endOf("month")],
                "Mois dernier": [
                    moment().subtract(1, "month").startOf("month"),
                    moment().subtract(1, "month").endOf("month"),
                ],
            },
        },
        cb
    );

    $("#reportrange2").daterangepicker(
        {
            startDate: start,
            endDate: end,
            opens: "right",
            ranges: {
                "Hier": [moment().subtract(1, "days"), moment().subtract(1, "days")],
                "Dernière semaine": [moment().subtract(6, "days"), moment()],
                "30 derniers jours": [moment().subtract(29, "days"), moment()],
                "Ce mois-ci": [moment().startOf("month"), moment().endOf("month")],
                "Mois dernier": [
                    moment().subtract(1, "month").startOf("month"),
                    moment().subtract(1, "month").endOf("month"),
                ],
            },
        },
        cb
    );

    cb(start, end);

    $('input[name="daterange-centered"]').daterangepicker({
        timePicker: true,
        buttonClasses: "btn btn-success",
        cancelClass: "btn-link bg-transparent rm-border text-danger",
        opens: "center",
        drops: "up",
        startDate: "12/12/2018",
        endDate: "12/18/2018",
    });
});
