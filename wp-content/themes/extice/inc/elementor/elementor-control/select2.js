(function ($, elementor, elementorCommon) {
    var ControlSelect2Query = elementor.modules.controls.Select2.extend({
        cache: {},
        isTitlesReceived: {},

        getQueryData: function () {
            const autocomplete = this.model.get('autocomplete');
            const controlName = this.model.get('name');
            return {
                autocomplete: autocomplete,
                control_name: controlName
            };
        },

        getSelect2DefaultOptions: function () {
            var self = this;
            return jQuery.extend(
                elementor.modules.controls.Select2.prototype.getSelect2DefaultOptions.apply(this, arguments),
                {
                    ajax: {
                        transport: function (params, success, failure) {
                            var data = self.getQueryData();
                            data.q = params.data.q;
                            data.control_name = self.model.get('name');

                            return elementorCommon.ajax.addRequest('panel_posts_control_filter_extice_query', {
                                data: data,
                                success: success,
                                error: failure
                            });
                        },
                        data: function (params) {
                            return {
                                q: params.term,
                                page: params.page
                            };
                        },
                        cache: true
                    },
                    escapeMarkup: function (markup) {
                        return markup;
                    },
                    minimumInputLength: 1
                }
            );
        },

        getValueTitles: function () {
            var self = this,
                controlName = this.model.get('name'),
                data = {};

            var ids = this.getControlValue(),
                action = 'query_control_value_extice_query';

            if (!_.isArray(ids)) {
                ids = [ids];
            }

            if (!ids.length) {
                this.ui.select.prop('disabled', false);
                this.$el.find('.elementor-control-spinner').remove();
                this.isTitlesReceived[controlName] = true;
                this.render();
                return;
            }

            elementorCommon.ajax.loadObjects({
                action: action,
                ids: ids,
                data: {
                    control_name: controlName
                },
                before: function () {
                    self.addControlSpinner();
                },
                success: function (ajaxData) {
                    self.isTitlesReceived[controlName] = true;
                    self.model.set('options', ajaxData);
                    self.ui.select.prop('disabled', false);
                    self.$el.find('.elementor-control-spinner').remove();
                    self.render();
                },
                error: function () {
                    self.isTitlesReceived[controlName] = true;
                    self.ui.select.prop('disabled', false);
                    self.$el.find('.elementor-control-spinner').remove();
                    self.render();
                }
            });

            // Fallback: Gỡ disabled sau 10 giây nếu AJAX không hoàn thành
            setTimeout(() => {
                if (!self.isTitlesReceived[controlName]) {
                    self.ui.select.prop('disabled', false);
                    self.$el.find('.elementor-control-spinner').remove();
                    self.isTitlesReceived[controlName] = true;
                    self.render();
                }
            }, 10000);
        },

        addControlSpinner: function () {
            this.ui.select.prop('disabled', true);
            this.$el.find('.elementor-control-spinner').remove();
            this.$el.find('.elementor-control-title').after(
                '<span class="elementor-control-spinner"> <i class="eicon-spinner eicon-animation-spin"></i> </span>'
            );
        },

        onReady: function () {
            var controlName = this.model.get('name');
            if (!this.isTitlesReceived[controlName]) {
                this.getValueTitles();
            }
        },

        onBeforeDestroy: function () {
            var controlName = this.model.get('name');
            this.isTitlesReceived[controlName] = false;
            this.cache[controlName] = null;
            this.ui.select.prop('disabled', false);
            this.$el.find('.elementor-control-spinner').remove();
        }
    });

    elementor.addControlView('extice_query', ControlSelect2Query);
})(jQuery, window.elementor, window.elementorCommon);