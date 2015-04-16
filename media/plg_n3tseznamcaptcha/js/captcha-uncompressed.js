/**
 * @package n3tSeznamCaptcha
 * @author Pavel Poles - n3t.cz
 * @copyright (C) 2012-2014 - Pavel Poles - n3t.cz
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/

var n3tSeznamCaptcha = new Class({

	Implements: [Options],

	options: {
    'url': '',
    'audio': true,
    'loading': false
	},

  player: null,

	initialize: function(options) {
		this.setOptions(options);
    $$('.seznam-captcha').each((function(el){
      this.loadCaptcha(el);
    }).bind(this));
	},

	loadCaptcha: function(wrapper) {
    if (this.options['loading'])
      wrapper.addClass('loading');
    new Request( {
      method: 'get',
      emulation: false,
      url: this.options['url']+'/plugins/captcha/n3tseznamcaptcha/captcha.create.php',
      onSuccess: (function(response, Xml) {
        this.createCaptcha(wrapper,response);
        wrapper.removeClass('loading');
        wrapper.removeClass('error');
      }).bind(this),
      onFailure: (function(xhr) {
        wrapper.removeClass('loading');
        wrapper.addClass('error');
      }).bind(this)
    }).send();
  },

  supportsAudio: function() {
    return typeOf(window.Audio) != 'null' && !Browser.ie;
  },

  supportsEmbed: function() {
    if (Browser.ie) return true;
    return navigator.mimeTypes["audio/wav"] && navigator.mimeTypes["audio/wav"].enabledPlugin;
  },

	createCaptcha: function(wrapper, hash) {
    if (!wrapper.retrieve('hash')) {
      var el = new Element('img',{
        'class': 'seznam-captcha-image',
        'alt': Joomla.JText._('PLG_CAPTCHA_N3TSEZNAMCAPTCHA_CAPTCHA')
      }).inject(wrapper);
      wrapper.store('image',el);

      var controls = new Element('div',{
        'class': 'seznam-captcha-controls'
      }).inject(wrapper);

      if (this.options['audio']) {
        wrapper.store('player',null);
        el = new Element('a',{
          'title': Joomla.JText._('PLG_CAPTCHA_N3TSEZNAMCAPTCHA_AUDIO_TITLE'),
          'class': 'seznam-captcha-audio'
        }).inject(controls);
        el.set('html','<span>'+Joomla.JText._('PLG_CAPTCHA_N3TSEZNAMCAPTCHA_AUDIO')+'</span>');
        wrapper.store('audio',el);
        el.addEvent('click',(function(e){
          var wrapper = e.target.getParent('.seznam-captcha');
          var url=wrapper.retrieve('audio').get('href');
          var player = wrapper.retrieve('player');

          if (this.supportsAudio()) {
            if (player) player.dispose();
            player=new Audio(url);
            player.play();
            e.stop();
          } else if (this.supportsEmbed()) {
            if (!player)
              player = new Element('div',{
                'style': {
                  'display': 'none'
                }
              }).inject(wrapper);
            player.set('html','<embed src="'+url+'" autostart hidden type="audio/x-wav" />');
            e.stop();
          }
          wrapper.store('player',player);
        }).bind(this));
        el = new Element('br',{}).inject(controls);
      }

      el = new Element('a',{
        'href': '#',
        'title': Joomla.JText._('PLG_CAPTCHA_N3TSEZNAMCAPTCHA_RELOAD_TITLE'),
        'class': 'seznam-captcha-reload'
      }).inject(controls);
      el.set('html','<span>'+Joomla.JText._('PLG_CAPTCHA_N3TSEZNAMCAPTCHA_RELOAD')+'</span>');
      el.addEvent('click', (function(e){
        this.loadCaptcha(e.target.getParent('.seznam-captcha'));
        e.stop();
      }).bind(this));

      el = new Element('input',{
        'type': 'hidden',
        'name': 'jform[captcha_hash]'
      }).inject(wrapper);
      wrapper.store('hash',el);

      var form = wrapper.getParent('form');
      var required = typeOf(form) != 'null' && form.hasClass('form-validate');

      el = new Element('input',{
        'type': 'text',
        'name': 'jform[captcha]',
        'id': 'jform_captcha',
        'class': 'seznam-captcha-answer',
        'size': 5,
        'maxlength': 5,
        'autocomplete': 'off'
      }).inject(wrapper);

      if (required) {
        el.addClass('required');
        el.set('aria-required', 'true');
        el.set('required', 'required');
        el.addEvent('blur', function(){return document.formvalidator.validate(this);});
      }
    }
    wrapper.retrieve('hash').set('value',hash);
    wrapper.retrieve('image').set('src','http://captcha.seznam.cz/captcha.getImage?hash='+hash);
    if (this.options['audio']) {
      if (!this.supportsAudio() && !this.supportsEmbed())
        wrapper.retrieve('audio').set('href',this.options['url']+'/plugins/captcha/n3tseznamcaptcha/captcha.audio.php?hash='+hash+'&d=1');
      else
        wrapper.retrieve('audio').set('href','http://captcha.seznam.cz/captcha.getAudio?hash='+hash);
    }
	}

});