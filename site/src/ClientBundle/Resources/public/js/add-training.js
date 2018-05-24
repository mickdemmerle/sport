$(document).ready(function () {
    (function () {

        const monthNames = ["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];

        let percentages = [
            0.5,
            0.6,
            0.5,
            0.6,
            0.5,
            0.6,
            0.5
        ];

        let series = [
            3,
            4,
            4,
            3,
            4,
            3,
            3
        ];

        let defaultPercentage = 0.5;
        let defaultSerie = 3;

        let ui = {
            exercisesRM: "input[name='exercisesRM[]']",

            groupExercises: '.table-exercises',
            selectExercises: '.js-select-exercises',

            btnAddExercise: '#btn-add-exercise',
            selectAllExercises: '#select-all-exercises',

            sessionWorkoutCount: '#sessionWorkoutCount',
            sessionWorkoutDateStart: '#sessionWorkoutDateStart',
            tableSessionWorkout: '.table-session-workout',
            newSessionWorkoutLine: 'js-new-session-workout-line',
            jsOldSessionWorkoutLine: 'js-old-session-workout-line',
            btnShowPreview: '.btn-show-preview',
            sessionWorkoutPreview: '.session-workout-preview',
            formTrainingConfiguration: '.form-training-configuration',
            previewClose: '.preview-close',

            chkDays: '.chk-days'
        };

        let manager = {
            init: function () {

                manager.refreshWorkoutSession();

                $(ui.btnAddExercise).click(function () {
                    manager.addNewExerciseLine();
                });

                $(ui.groupExercises).on('change', ui.selectExercises, function () {
                    manager.refreshWorkoutSession();
                })

                $(ui.sessionWorkoutCount).change(function () {
                    manager.refreshWorkoutSession();
                });

                $(ui.sessionWorkoutDateStart).change(function () {
                    manager.refreshWorkoutSession();
                });

                $(ui.groupExercises).on('change', ui.exercisesRM, function () {
                    manager.refreshWorkoutSession();
                });

                $(ui.chkDays).change(function() {
                   manager.refreshWorkoutSession();
                });

                $(ui.btnShowPreview).click(function() {
                    $(ui.sessionWorkoutPreview).show();
                    //$(ui.formTrainingConfiguration).hide();
                });

                $(ui.previewClose).click(function() {
                    $(ui.sessionWorkoutPreview).hide();
                });
            },
            addNewExerciseLine: function () {
                var selectAllExercises = $(ui.selectAllExercises).html();

                $('.table-exercises tr:last').after('<tr>' +
                    '<td><select class="js-select-exercises" name="exercisesName[]">' + selectAllExercises + '</select></td>' +
                    '<td><input class="form-control m-input-text" name="exercisesRM[]" type="number"></td>' +
                    '</tr>');
            },
            refreshWorkoutSession: function () {

                let dateStart = $(ui.sessionWorkoutDateStart).val();
                let dateDays = new Date(dateStart);
                let days = manager.getSelectedDays();
                let currentDay = dateDays.getDay() - 1;
                let positionDays = manager.computeFirstPositionDays(dateDays, days);

                $('.' + ui.newSessionWorkoutLine).remove();

                if (days.length === 0) {
                    return false;
                }

                let countOldSessionWorkout = $('.' + ui.jsOldSessionWorkoutLine).length;
                let countSessionWorkoutToAdd = $(ui.sessionWorkoutCount).val() - countOldSessionWorkout;
                for (let i = 0; i < countSessionWorkoutToAdd; i++) {

                    var daysCountToAdd = manager.calculateNumberOfDaysToAdd(currentDay, days[positionDays]);
                    dateDays = manager.addDaysToDate(dateDays, daysCountToAdd);
                    currentDay = days[positionDays];

                    positionDays++;

                    if (positionDays >= days.length) {
                        positionDays = 0;
                    }

                    $(ui.tableSessionWorkout + ' tr:last').after('<tr class="' + ui.newSessionWorkoutLine + '">' +
                        '<td>' + (i + 1 + countOldSessionWorkout) + '</td>' +
                        '<td><span>' + manager.formatDayDate(dateDays) + '</span><span>' + manager.formatMonthDate(dateDays) + '</span></td>' +
                        '<td>' + manager.computeProgramme(i) + '</td>' +
                        '</tr>');
                }
            },
            getSelectedDays: function () {
                return $("input[name='days[]']").map(function () {
                    if ($(this).is(':checked')) {
                        return $(this).val();
                    }
                }).get();
            },
            getSelectedExercises: function () {
                let exercises = [];
                let exercisesRM = [];

                $(ui.exercisesRM).each(function () {
                    exercisesRM.push($(this).val());
                })

                let positionExercises = 0;
                $(ui.selectExercises).each(function () {
                    exercises.push({
                        'id': $(this).val(),
                        'name': $(this).find('option:selected').text(),
                        'repetitionMax': exercisesRM[positionExercises]
                    });

                    positionExercises++;
                });

                return exercises;
            },
            formatDayDate: function(date) {
                return (date.getDate() < 10) ? '0' + date.getDate() : date.getDate();
            },
            formatMonthDate: function (date) {
                return monthNames[date.getMonth()];
            },
            addDaysToDate: function (date, daysCount) {
                return new Date(date.getFullYear(), date.getMonth(), date.getDate() + daysCount);
            },
            calculateNumberOfDaysToAdd: function (currentDay, daysPosition) {
                if (currentDay == daysPosition) {
                    return 7;
                }

                if (currentDay < daysPosition) {
                    return daysPosition - currentDay;
                }

                return parseInt(6 - currentDay) + parseInt(daysPosition) + 1;
            },
            computeFirstPositionDays: function (dateDays, days) {
                let positionDays = 0;
                let currentDay = dateDays.getDay() - 1;

                for (let i = 0; i < days.length; i++) {
                    if (days[i] > currentDay) {
                        positionDays = i;
                        break;
                    }
                }

                return positionDays;
            },
            computeProgramme: function (workoutSessionPosition) {

                let exercises = manager.getSelectedExercises();

                var html = '<div class="exercices-details">';

                for (let j = 0; j < exercises.length; j++) {
                    let percentage = percentages[workoutSessionPosition];
                    if (percentage == undefined) {
                        percentage = defaultPercentage;
                    }

                    let serie = series[workoutSessionPosition];
                    if (serie == undefined) {
                        serie = defaultSerie;
                    }

                    let timeBreak = ((workoutSessionPosition+1)%2 == 0) ? 20 : 10;

                    let repetitionMax = exercises[j].repetitionMax;
                    let repetitionMaxFinal = (repetitionMax == "") ? "" : Math.round(parseInt(repetitionMax) * percentage);

                    if (exercises[j].name == '-') {
                        continue;
                    }

                    html += '<div class="exercice-details">';
                    html += '<span class="exercice-details-name">' + exercises[j].name + '</span>';
                    html += '<span class="exercice-details-serie">';
                    if (repetitionMaxFinal != "") {
                        html += '<i class="material-icons">loop</i>'
                            + '<span>' + serie + '</span>'
                            + '<i class="material-icons">clear</i>'
                            + '<span>' + repetitionMaxFinal + '</span>';
                    }
                    html += '</span>';
                    html += '<span class="exercice-details-break">' + timeBreak + ' sec</span>';
                    html += '</div>';

                }
                html += '</div>';

                return html;
            }
        };


        manager.init();
    })();

});