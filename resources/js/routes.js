const routes = {
    "debugbar.openhandler": {
        "uri": "_debugbar\/open"
    },
    "debugbar.clockwork": {
        "uri": "_debugbar\/clockwork\/{id}"
    },
    "debugbar.telescope": {
        "uri": "_debugbar\/telescope\/{id}"
    },
    "debugbar.assets.css": {
        "uri": "_debugbar\/assets\/stylesheets"
    },
    "debugbar.assets.js": {
        "uri": "_debugbar\/assets\/javascript"
    },
    "login": {
        "uri": "login"
    },
    "logout": {
        "uri": "logout"
    },
    "register": {
        "uri": "register"
    },
    "password.request": {
        "uri": "password\/reset"
    },
    "password.email": {
        "uri": "password\/email"
    },
    "password.reset": {
        "uri": "password\/reset\/{token}"
    },
    "password.update": {
        "uri": "password\/reset"
    },
    "password.confirm": {
        "uri": "password\/confirm"
    },
    "dashboard": {
        "uri": "dashboard"
    },
    "editors": {
        "uri": "dashboard\/editor"
    },
    "page.index": {
        "uri": "dashboard\/page"
    },
    "page.create": {
        "uri": "dashboard\/page\/create"
    },
    "page.store": {
        "uri": "dashboard\/page"
    },
    "page.show": {
        "uri": "dashboard\/page\/{page}"
    },
    "page.edit": {
        "uri": "dashboard\/page\/{page}\/edit"
    },
    "page.tojson": {
        "uri": "dashboard\/page\/listtojson"
    },
    "unisharp.lfm.show": {
        "uri": "dashboard\/filemanager"
    },
    "unisharp.lfm.getErrors": {
        "uri": "dashboard\/filemanager\/errors"
    },
    "unisharp.lfm.upload": {
        "uri": "dashboard\/filemanager\/upload"
    },
    "unisharp.lfm.getItems": {
        "uri": "dashboard\/filemanager\/jsonitems"
    },
    "unisharp.lfm.move": {
        "uri": "dashboard\/filemanager\/move"
    },
    "unisharp.lfm.domove": {
        "uri": "dashboard\/filemanager\/domove"
    },
    "unisharp.lfm.getAddfolder": {
        "uri": "dashboard\/filemanager\/newfolder"
    },
    "unisharp.lfm.getFolders": {
        "uri": "dashboard\/filemanager\/folders"
    },
    "unisharp.lfm.getCrop": {
        "uri": "dashboard\/filemanager\/crop"
    },
    "unisharp.lfm.getCropimage": {
        "uri": "dashboard\/filemanager\/cropimage"
    },
    "unisharp.lfm.getCropnewimage": {
        "uri": "dashboard\/filemanager\/cropnewimage"
    },
    "unisharp.lfm.getRename": {
        "uri": "dashboard\/filemanager\/rename"
    },
    "unisharp.lfm.getResize": {
        "uri": "dashboard\/filemanager\/resize"
    },
    "unisharp.lfm.performResize": {
        "uri": "dashboard\/filemanager\/doresize"
    },
    "unisharp.lfm.getDownload": {
        "uri": "dashboard\/filemanager\/download"
    },
    "unisharp.lfm.getDelete": {
        "uri": "dashboard\/filemanager\/delete"
    },
    "unisharp.lfm.": {
        "uri": "dashboard\/filemanager\/demo"
    },
    "post": {
        "uri": "dashboard\/post"
    },
    "post.new": {
        "uri": "dashboard\/post\/new"
    },
    "post.category": {
        "uri": "dashboard\/post\/categorys"
    },
    "post.tag": {
        "uri": "dashboard\/post\/tags"
    },
    "template": {
        "uri": "dashboard\/template"
    },
    "template.header": {
        "uri": "dashboard\/template\/header"
    },
    "template.section": {
        "uri": "dashboard\/template\/sections"
    },
    "template.footer": {
        "uri": "dashboard\/template\/footer"
    },
    "template.widget": {
        "uri": "dashboard\/template\/widget"
    },
    "user": {
        "uri": "dashboard\/user"
    },
    "user.profile": {
        "uri": "dashboard\/user\/profile\/{id}"
    },
    "user.new": {
        "uri": "dashboard\/user\/new"
    },
    "user.permissions": {
        "uri": "dashboard\/user\/permissions"
    },
    "setting": {
        "uri": "dashboard\/setting"
    }
};

const route = (routeName, params = [], absolute = true) => {
  const _route = routes[routeName];
  if (_route == null) throw "Requested route doesn't exist";

  let uri = _route.uri;

  const matches = uri.match(/{[\w]+\??}/g) || [];
  const optionals = uri.match(/{[\w]+\?}/g) || [];

  const requiredParametersCount = matches.length - optionals.length;

  if (params instanceof Array) {
    if (params.length < requiredParametersCount) throw "Missing parameters";

    for (let i = 0; i < requiredParametersCount; i++)
      uri = uri.replace(/{[\w]+\??}/, params.shift());

    for (let i = 0; i < params.length; i++)
      uri += (i ? "&" : "?") + params[i] + "=" + params[i];
  } else if (params instanceof Object) {
    let extraParams = matches.reduce((ac, match) => {
      let key = match.substring(1, match.length - 1);
      let isOptional = key.endsWith("?");
      if (params.hasOwnProperty(key.replace("?", ""))) {
        uri = uri.replace(new RegExp(match.replace("?", "\\?"), "g"), params[key.replace("?", "")]);
        delete ac[key.replace("?", "")];
      } else if (isOptional) {
          uri = uri.replace("/" + new RegExp(match, "g"), "");
      }
      return ac;
    }, params);

    Object.keys(extraParams).forEach((key, i) => {
      uri += (i ? "&" : "?") + key + "=" + extraParams[key];
    });
  }

  if (optionals.length > 0) {
    for (let i in optionals) {
      uri = uri.replace("/" + optionals[i], "");
    }
  }

  if (uri.includes("}")) throw "Missing parameters";

  if (absolute && process.env.MIX_APP_URL)
    return process.env.MIX_APP_URL + "/" + uri;
  return "/" + uri;
};

export { route };
