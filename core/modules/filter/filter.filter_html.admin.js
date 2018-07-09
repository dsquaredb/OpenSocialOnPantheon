/**
* DO NOT EDIT THIS FILE.
* See the following change record for more information,
* https://www.drupal.org/node/2815083
* @preserve
**/

(function ($, Drupal, _, document) {
  if (Drupal.filterConfiguration) {
    Drupal.filterConfiguration.liveSettingParsers.filter_html = {
      getRules: function getRules() {
        var currentValue = $('#edit-filters-filter-html-settings-allowed-html').val();
        var rules = Drupal.behaviors.filterFilterHtmlUpdating._parseSetting(currentValue);

        var rule = new Drupal.FilterHTMLRule();
        rule.restrictedTags.tags = ['*'];
        rule.restrictedTags.forbidden.attributes = ['style', 'on*'];
        rules.push(rule);

        return rules;
      }
    };
  }

  Drupal.behaviors.filterFilterHtmlUpdating = {
    $allowedHTMLFormItem: null,

    $allowedHTMLDescription: null,

    userTags: {},

    autoTags: null,

    newFeatures: {},

    attach: function attach(context, settings) {
      var that = this;
      $(context).find('[name="filters[filter_html][settings][allowed_html]"]').once('filter-filter_html-updating').each(function () {
        that.$allowedHTMLFormItem = $(this);
        that.$allowedHTMLDescription = that.$allowedHTMLFormItem.closest('.js-form-item').find('.description');
        that.userTags = that._parseSetting(this.value);

        $(document).on('drupalEditorFeatureAdded', function (e, feature) {
          that.newFeatures[feature.name] = feature.rules;
          that._updateAllowedTags();
        }).on('drupalEditorFeatureModified', function (e, feature) {
          if (that.newFeatures.hasOwnProperty(feature.name)) {
            that.newFeatures[feature.name] = feature.rules;
            that._updateAllowedTags();
          }
        }).on('drupalEditorFeatureRemoved', function (e, feature) {
          if (that.newFeatures.hasOwnProperty(feature.name)) {
            delete that.newFeatures[feature.name];
            that._updateAllowedTags();
          }
        });

        that.$allowedHTMLFormItem.on('change.updateUserTags', function () {
          that.userTags = _.difference(that._parseSetting(this.value), that.autoTags);
        });
      });
    },
    _updateAllowedTags: function _updateAllowedTags() {
      this.autoTags = this._calculateAutoAllowedTags(this.userTags, this.newFeatures);

      this.$allowedHTMLDescription.find('.editor-update-message').remove();

      if (!_.isEmpty(this.autoTags)) {
        this.$allowedHTMLDescription.append(Drupal.theme('filterFilterHTMLUpdateMessage', this.autoTags));
        var userTagsWithoutOverrides = _.omit(this.userTags, _.keys(this.autoTags));
        this.$allowedHTMLFormItem.val(this._generateSetting(userTagsWithoutOverrides) + ' ' + this._generateSetting(this.autoTags));
      } else {
          this.$allowedHTMLFormItem.val(this._generateSetting(this.userTags));
        }
    },
    _calculateAutoAllowedTags: function _calculateAutoAllowedTags(userAllowedTags, newFeatures) {
      var editorRequiredTags = {};

      Object.keys(newFeatures || {}).forEach(function (featureName) {
        var feature = newFeatures[featureName];
        var featureRule = void 0;
        var filterRule = void 0;
        var tag = void 0;

        for (var f = 0; f < feature.length; f++) {
          featureRule = feature[f];
          for (var t = 0; t < featureRule.required.tags.length; t++) {
            tag = featureRule.required.tags[t];
            if (!_.has(editorRequiredTags, tag)) {
              filterRule = new Drupal.FilterHTMLRule();
              filterRule.restrictedTags.tags = [tag];

              filterRule.restrictedTags.allowed.attributes = featureRule.required.attributes.slice(0);
              filterRule.restrictedTags.allowed.classes = featureRule.required.classes.slice(0);
              editorRequiredTags[tag] = filterRule;
            } else {
                filterRule = editorRequiredTags[tag];
                filterRule.restrictedTags.allowed.attributes = _.union(filterRule.restrictedTags.allowed.attributes, featureRule.required.attributes);
                filterRule.restrictedTags.allowed.classes = _.union(filterRule.restrictedTags.allowed.classes, featureRule.required.classes);
              }
          }
        }
      });

      var autoAllowedTags = {};
      Object.keys(editorRequiredTags).forEach(function (tag) {
        if (!_.has(userAllowedTags, tag)) {
          autoAllowedTags[tag] = editorRequiredTags[tag];
        } else {
            var requiredAttributes = editorRequiredTags[tag].restrictedTags.allowed.attributes;
            var allowedAttributes = userAllowedTags[tag].restrictedTags.allowed.attributes;
            var needsAdditionalAttributes = requiredAttributes.length && _.difference(requiredAttributes, allowedAttributes).length;
            var requiredClasses = editorRequiredTags[tag].restrictedTags.allowed.classes;
            var allowedClasses = userAllowedTags[tag].restrictedTags.allowed.classes;
            var needsAdditionalClasses = requiredClasses.length && _.difference(requiredClasses, allowedClasses).length;
            if (needsAdditionalAttributes || needsAdditionalClasses) {
              autoAllowedTags[tag] = userAllowedTags[tag].clone();
            }
            if (needsAdditionalAttributes) {
              autoAllowedTags[tag].restrictedTags.allowed.attributes = _.union(allowedAttributes, requiredAttributes);
            }
            if (needsAdditionalClasses) {
              autoAllowedTags[tag].restrictedTags.allowed.classes = _.union(allowedClasses, requiredClasses);
            }
          }
      });

      return autoAllowedTags;
    },
    _parseSetting: function _parseSetting(setting) {
      var node = void 0;
      var tag = void 0;
      var rule = void 0;
      var attributes = void 0;
      var attribute = void 0;
      var allowedTags = setting.match(/(<[^>]+>)/g);
      var sandbox = document.createElement('div');
      var rules = {};
      for (var t = 0; t < allowedTags.length; t++) {
        sandbox.innerHTML = allowedTags[t];
        node = sandbox.firstChild;
        tag = node.tagName.toLowerCase();

        rule = new Drupal.FilterHTMLRule();

        rule.restrictedTags.tags = [tag];

        attributes = node.attributes;
        for (var i = 0; i < attributes.length; i++) {
          attribute = attributes.item(i);
          var attributeName = attribute.nodeName;

          if (attributeName   'class') {
            var attributeValue = attribute.textContent;
            rule.restrictedTags.allowed.classes = attributeValue.split(' ');
          } else {
            rule.restrictedTags.allowed.attributes.push(attributeName);
          }
        }

        rules[tag] = rule;
      }
      return rules;
    },
    _generateSetting: function _generateSetting(tags) {
      return _.reduce(tags, function (setting, rule, tag) {
        if (setting.length) {
          setting += ' ';
        }

        setting += '<' + tag;
        if (rule.restrictedTags.allowed.attributes.length) {
          setting += ' ' + rule.restrictedTags.allowed.attributes.join(' ');
        }

        if (rule.restrictedTags.allowed.classes.length) {
          setting += ' class="' + rule.restrictedTags.allowed.classes.join(' ') + '"';
        }

        setting += '>';
        return setting;
      }, '');
    }
  };

  Drupal.theme.filterFilterHTMLUpdateMessage = function (tags) {
    var html = '';
    var tagList = Drupal.behaviors.filterFilterHtmlUpdating._generateSetting(tags);
    html += '<p class="editor-update-message">';
    html += Drupal.t('Based on the text editor configuration, these tags have automatically been added: <strong>@tag-list</strong>.', { '@tag-list': tagList });
    html += '</p>';
    return html;
  };
})(jQuery, Drupal, _, document);