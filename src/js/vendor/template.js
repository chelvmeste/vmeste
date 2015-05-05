
var Template = function() {

    this.cachedTemplates = {};
    this.lazyLoad = [];
    this.lazyBind = [];

    this.clearLazyLoad = function() {
        this.lazyLoad = [];
    };
    this.clearLazyBind = function() {
        this.lazyBind = [];
    };
    this.clearCachedTemplates = function() {
        this.cachedTemplates = {};
    };


    this.buildTemplate = function(template,data,element,bindType,callback,partials) {
        if (this.cachedTemplates[template] === undefined) {
            this.lazyLoad.push(template);
        }
        if (partials !== undefined) {
            var tmpThis = this;
            $.each(partials,function(key,partialTemplate){
                if (tmpThis.cachedTemplates[partialTemplate] === undefined) {
                    tmpThis.lazyLoad.push(partialTemplate);
                }
            });
        }
        this.lazyBind.push({
            template: template,
            data: data,
            element: element,
            bindType: bindType,
            callback: callback,
            partials: partials
        });
    };

    this.renderTemplates = function() {
        if (this.lazyLoad.length > 0) {
            this.loadLazyTemplates();
        } else {
            if (this.lazyBind.length > 0) {
                for (var i=0;i<=this.lazyBind.length-1;i++) {
                    var compiledTemplate = '';
                    if (this.cachedTemplates[this.lazyBind[i].template] !== undefined) {
                        var partials = {};
                        if (this.lazyBind[i].partials !== undefined) {
                            var tmpThis = this;
                            $.each(this.lazyBind[i].partials,function(key,partialTemplate){
                                partials[key] = tmpThis.cachedTemplates[partialTemplate] !== undefined ? tmpThis.cachedTemplates[partialTemplate] : ''; // TODO bind default partial
                            });
                        }
                        compiledTemplate = Mustache.render(this.cachedTemplates[this.lazyBind[i].template],this.lazyBind[i].data,partials);
                    } else {
                        // TODO bind default template :S
                    }
                    this.bindTemplate(compiledTemplate,this.lazyBind[i].element,this.lazyBind[i].bindType);
                    if (this.lazyBind[i].callback !== undefined) {
                        this.lazyBind[i].callback();
                    }
                }
            }
            this.clearLazyBind();
        }
    };

    this.bindTemplate = function(compiledTemplate,element,bindType) {
        var el = $(element);
        if (!el.length) {
            console.log('No bind element found: '+element);
            return;
        }
        switch (bindType) {
            case 'append':
                el.append(compiledTemplate);
                break;
            case 'html':
                el.html(compiledTemplate);
                break;
            case 'after':
                el.after(compiledTemplate);
                break;
            case 'before':
                el.before(compiledTemplate);
                break;
            default:
                el.html(compiledTemplate);
                console.log('No bind type set');
                break;
        }
    };

    this.loadLazyTemplates = function() {

        var tmpThis = this;
        this.lazyLoad = this.arrayUnique(this.lazyLoad);
        if (this.lazyLoad.length === 0) {
            console.log('No templates to load...');
            return;
        }

        if (this.lazyLoad.length > 0){
            $.ajax({
                url: '/ajax/template',
                type: 'POST',
                dataType: 'JSON',
                data: {
                    'templates[]': this.lazyLoad
                },
                success: function(data) {
                    for (var template in data.templates) {
                        tmpThis.cachedTemplates[template] = data.templates[template].html;
                    }
                    tmpThis.clearLazyLoad();
                    tmpThis.renderTemplates();
                },
                error: function() {
                    console.log('Error while loading templates');
                }
            });
        } else {
            tmpThis.clearLazyLoad();
            tmpThis.renderTemplates();
        }
    };

    this.addLastKeyToArray = function(array) {
        if (array !== undefined && array !== null && array.length > 0) {
            array[array.length-1].last = true;
        }
        return array;
    };

    this.arrayUnique = function(a) {
        return a.reduce(function(p, c) {
            if (p.indexOf(c) < 0) p.push(c);
            return p;
        }, []);
    };

};

var $template = new Template();