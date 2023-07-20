# 9. Asset Bundling (Vite)

### 1. Configuring Vite
Ref [vite.config.js](../vite.config.js). 

```js
export default defineConfig({
    plugin: [
        laravel(['resources/js/app.js',...morefile]),
    ],
});
```
If you are building an SPA, including applications built using Inertia, Vite works best without CSS entry points:

```js
import '../css/app.css';
```

### 2. Loading Scripts And Styles
Ref [responsePractice.blade.php](../resources/views/responsePractice.blade.php). exp: 9.2

```html
@vite(['resoureces/css/app.css',...moreFile])
```

### 3. Aliase

```js
//default aliase
'@' => '/resoureces/js'
```
Overwrite the aliase in vite.config.js
```js
    //...other code../,
    resolve: {
        alias: {
            '@': '/resourece/ts'
        },
    },
```

### 4. Vue
To add Vue in existing build you will need to install the `@vitejs/plugin-vue` plugin:
```
$ npm install --save-dev @vitejs/plugin-vue
```
And include it in `vite.config.js`:
```js
plugins: [
        laravel(['resources/js/app.js']),
        vue({
            template: {
                transformAssetUrls: {
                    // The Vue plugin will re-write asset URLs, when referenced
                    // in Single File Components, to point to the Laravel web
                    // server. Setting this to `null` allows the Laravel plugin
                    // to instead re-write asset URLs to point to the Vite
                    // server instead.
                    base: null,
 
                    // The Vue plugin will parse absolute URLs and treat them
                    // as absolute paths to files on disk. Setting this to
                    // `false` will leave absolute URLs un-touched so they can
                    // reference assets in the public directory as expected.
                    includeAbsolute: false,
                },
            },
        }),
    ],
```

### 5. React
To add Vue in existing build you will need to install the `@vitejs/plugin-react` plugin:
```
$ npm install --save-dev @vitejs/plugin-react
```
And include it in `vite.config.js`:
```js
     plugins: [
        laravel(['resources/js/app.jsx']),
        react(),
    ],
```
You will also need to include the additional @viteReactRefresh Blade directive alongside your existing @vite directive.
```js
@viteReactRefresh
@vite('resources/js/app.jsx')
```

### 6. Inertia
The Laravel Vite plugin provides a convenient resolvePageComponent function to help you resolve your Inertia 
page components. Below is an example of the helper in use with Vue 3; however, you may also utilize the function 
in other frameworks such as React:
```js
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
 
createInertiaApp({
  resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
  setup({ el, App, props, plugin }) {
    return createApp({ render: () => h(App, props) })
      .use(plugin)
      .mount(el)
  },
});
```

### 7. URL Processing
Ref [responsePractice.blade.php](../resources/views/responsePractice.blade.php). exp: 9.7

To enable asset binding via vite, You have to use relative asset paths.
```html
<img src="../../images/img.png">
```

## Working With Blade & Routes

### 8. Processing Static Assets With Vite
Add asset path to app.js file to processe those file by vite:
```js
import.meta.glob([
    '../images/**',
    '../fonts/**',
]);
```
add asset in blade.php with `vite::asset`:
```html
<img src="{{Vite::asset('resoureces/images.img.jpg')}}">
```

### 9. Custom Base URLs
If your Vite compiled assets are deployed to a domain separate from your application, such as via a CDN, you must specify the ASSET_URL environment variable within your application's .env file:
```
ASSET_URL=https://cdn.example.com
```

### 10. Disabling Vite In Tests
If you would prefer to mock Vite during testing, you may call the withoutVite method, which is is available for 
any tests that extend Laravel's TestCase class:
```php
class ExampleTest extends TestCase
{
    public function test_without_vite_example(): void
    {
        $this->withoutVite();
 
        // ...
    }
}
```