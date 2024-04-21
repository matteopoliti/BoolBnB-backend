# Comandi da lanciare da terminale, una volta importato il template e in VS Code:

1. Scaricare le dipendenze per Laravel e per Vite:
``
composer install
``
e 
``
npm install
``


2. Creare nella root folder un file senza nome .env con questo comando:
``
cp .env.example .env
``
e generare la chiave univoca per il .env:
``
php artisan key:generate
``


3. Avviare prima il server Laravel:
``
php artisan serve
``
e a seguire avviare il server Vite e consentire la compilazione dei file SASS (in un terminale a parte appena splittato):
``
npm run dev
``

4. Per installare bootstrap usare il comando: 
``
npm i --save bootstrap @popperjs/core
``
poi inserire `@import "bootstrap/scss/bootstrap";` in scss/app.scss



## ordine di creazione file

creare una tabella e popolare i dati
1. migration
    ```php artisan make:migration create_comics_table```

    Popoliamo lo schema della migration con le colonne

2. modello
    ```php artisan make:model Comic```
3. seeder
    ```php artisan make:seeder ComicSeeder```

    Per lanciare il comando del seeder dopo averlo completato possiamo usare: 
    ```php artisan db:seed --class=ComicSeeder```

    se voglio lanciare un seeder multiplo, devo popolare DatabaseSeeder.php con questo codice di esempio:
    ```php
        public function run(): void
    {
            $this->call([
                PastasSeeder::class,
                TestSeeder::class
            ]);

    }
    ```

    e poi lanciare il comando terminale, per usare i seeder nell'ordine di disposizione nell'array:
    ```php artisan db:seed ```

4. controller
    ```php artisan make:controller ComicsController```

Shortcut per il terminale se non vogliamo lanciare i comandi precedenti singolarmente

```php artisan make:model Comic -msc```

oppure se devo fare le crud:
```php artisan make:model Comic -msr```

TIP: La r sta per un controller resource per utilizzare le funzioni CRUD

5. rotte
    modifichiamo il file web.php

    se dobbiamo creare una rotta per le crud usiamo questa sintassi:
    ```Route::resource('comics', ComicController::class );```

    Se abbiamo usato un controller resource possiamo visualizzare le rotte che genera laravel utilizzando il comando:
    ```php artisan route:list```

    TIP: Primo parametro della funzione e il nome della URI che genererà laravel 
    localhost/comics

6. Modifichiamo le diverse funzioni nel controller adibito alla rotta per le CRUD oppure per il richiamo di view normalli

Se vogliamo svuotare una tabella da tutti i records creati:
```php artisan migrate:fresh --seed```

Per svuotare una tabella specifica
```php artisan migrate:fresh --seed --seeder=TestSeeder```


CRUD:

index:
```php
public function index()
    {
        $pastas = Pasta::All();

        return view('pages.pastasView.index', compact('pastas'));
    }
```

show:
```php
public function show(Pasta $pasta)
    {
        // $pasta = Pasta::find($id);

        return view('pages.pastasView.show', compact('pasta'));
    }
```

delete:
```php
public function destroy(string $id)
    {
        $pasta = Pasta::find($id);

        $pasta->delete();

        return redirect()->route('pastas.index');
    }
```

create:
```php
public function create()
    {
        return view('pages.pastasView.create');
    }
```
store:
```php
public function store(Request $request)
    {

        //Se avete bisogno della validazione:
        /*$request->validate([
            'title' => 'required|unique:posts|max:255',
        ]);*/

        $formData = $request->all();

        $newPasta = new Pasta();
        $newPasta->fill($formData);

        $newPasta->save();

        return redirect()->route('pastas.show', ['pasta' => $newPasta->id]);
    }
```

edit:
```php
public function edit(string $id)
    {
        $pasta = Pasta::findOrFail($id);
        // $pasta->findOrFail();
        return view('pages.pastasView.edit', compact('pasta'));
    }
```

update:
```php
public function update(Request $request, string $id)
    {

        //Se avete bisogno della validazione:
        /*$request->validate([
            'title' => 'required|unique:posts|max:255',
        ]);*/

        $formData = $request->all();

        $pasta = Pasta::find($id);

        $pasta->update($formData);

        return redirect()->route('pastas.index');

    }
```

Validazione:
Se è stata usata nel controller dobbiamo ricordarci dimostrare gli errori nella views sopra i forms:

```php
@if ($errors->any())
   <div class="alert alert-danger">
       <ul>
           @foreach ($errors->all() as $error)
               <li>{{ $error }}</li>
           @endforeach
       </ul>
   </div>
@endif
```