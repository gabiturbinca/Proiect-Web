# GiW — Gift Web Manager

Asistent digital pentru alegerea cadourilor în funcție de preferințe, circumstanțe
(zi de naștere, Crăciun, absolvire…), context social (familial, colegial, profesional,
romantic), buget, marcă și anotimp. Aplicație Web realizată în cadrul cursului de
Tehnologii Web.

> Aplicație bazată pe servicii: backend PHP (fără framework) expunând un API REST,
> client HTML/CSS/JavaScript vanilla care consumă API-ul asincron prin Ajax,
> persistență în PostgreSQL.

🌐 **Site live:** [giw.onrender.com](https://giw.onrender.com)

   **Videoclip de prezentare:** [Prezentare Proiect](https://youtu.be/O1jbvlFCVVc)

## Cuprins

- [Funcționalități](#funcționalități)
- [Stack tehnologic](#stack-tehnologic)
- [Structura proiectului](#structura-proiectului)
- [Rulare locală](#rulare-locală)
- [Variabile de mediu](#variabile-de-mediu)
- [Deploy](#deploy)
- [Prezentare API](#prezentare-api)
- [Documentație](#documentație)
- [Licență](#licență)

## Funcționalități

- **Autentificare** — register/login cu JWT în cookie HttpOnly, protecție CSRF
  (double-submit cookie), rate limiting (5 încercări / 5 min), 3 fluxuri de resetare a parolei.
- **Motor de recomandare** — filtrare după buget, categorii, mărci, tag-uri; scoring
  compozabil (Strategy + Composite) după potrivire context/circumstanță și popularitate.
- **Recenzii** — o recenzie per utilizator per cadou (notă 1–5 + comentariu), CRUD.
- **Comenzi** — plasare cu expediere anonimă opțională, urmărire status, anulare.
- **Modul de administrare** — CRUD cadouri/categorii, încărcare imagini (validare MIME),
  gestiune utilizatori și comenzi, cereri de resetare parolă.
- **Rapoarte** — generate în HTML, JSON, CSV și PDF (Factory pattern).
- **Import/Export** — date în formate deschise (CSV/JSON), compatibile round-trip.
- **Integrări externe** — import catalog din DummyJSON, imagini categorii din Unsplash.

## Stack tehnologic

| Strat | Tehnologie |
|-------|------------|
| Backend | PHP 8.3 (fără framework) |
| Bază de date | PostgreSQL |
| Frontend | HTML5, CSS3 (design tokens, BEM), JavaScript vanilla |
| PDF | dompdf (via Composer) |
| Server | Apache |
| Containerizare | Docker |
| Hosting | Render |

## Structura proiectului

```
.
├── api/                    # Backend
│   ├── controllers/        # Controllere HTTP
│   ├── services/           # Logica de business (+ scoring/, reports/)
│   ├── repositories/       # Acces la date (PDO)
│   ├── models/             # Entități de domeniu
│   ├── dtos/               # Data Transfer Objects (readonly)
│   ├── middleware/         # Auth, Csrf, Admin, RateLimiter
│   ├── Router.php          # Routing manual
│   └── routes.php          # Definiția rutelor
├── config/                 # Container DI, autoload, env, handler excepții
├── public/                 # Document root
│   ├── api.php             # Front controller (API)
│   ├── *.php               # Pagini (home, login, recomandare, admin…)
│   ├── css/                # Foi de stil stratificate (variables→base→layout→components→pages)
│   ├── js/                 # JavaScript (api.js, main.js, pages/)
│   └── uploads/            # Imagini încărcate
├── templates/              # Partiale PHP (header, footer, admin_layout)
├── db/                     # Schema + migrări (init.sql → v5) + seed
├── utils/                  # Helperi, excepții, validare
├── docs/                   # Raportul proiectului (srs.html) + assets
├── Dockerfile
└── render.yaml
```

## Rulare locală

**Cerințe:** PHP 8.3 (cu extensiile `pdo_pgsql`, `mbstring`, `gd`, `zip`), PostgreSQL, Composer.

```bash
# 1. Instalează dependențele
composer install

# 2. Creează baza de date și aplică schema + migrările în ordine
createdb proiect_web
psql -d proiect_web -f db/init.sql
psql -d proiect_web -f db/v3.sql
psql -d proiect_web -f db/v4_schimbareparola.sql
psql -d proiect_web -f db/v5_alteraretimestampuri.sql
psql -d proiect_web -f db/insertdata.sql   # date de start

# 3. Configurează mediul
cp .env.example .env        # apoi completează valorile

# 4. Pornește serverul (document root = public/)
php -S localhost:8000 -t public
```

Aplicația va fi disponibilă la `http://localhost:8000`.

## Variabile de mediu

| Variabilă | Descriere |
|-----------|-----------|
| `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, `DB_PASS` | Conexiunea PostgreSQL |
| `APP_ENV` | `development` sau `production` |
| `JWT_SECRET` | Secret pentru semnarea JWT — generează cu `php -r "echo base64_encode(random_bytes(32));"` |
| `UNSPLASH_ACCESS_KEY` | Cheia API Unsplash (opțional; necesară doar pentru imagini auto la categorii) |

> Încărcarea configurației este tolerantă: în producție citește din mediul containerului,
> iar local din fișierul `.env` dacă există.

## Deploy

Aplicația rulează containerizat pe **Render**, accesibilă la
[giw.onrender.com](https://giw.onrender.com) (vezi [`render.yaml`](render.yaml) și
[`Dockerfile`](Dockerfile)). Render injectează variabilele de mediu (inclusiv datele bazei
de date administrate), iar Apache le expune către PHP prin directive `PassEnv`. La deploy,
se aplică schema și migrările pe baza de date administrată.

## Prezentare API

API REST cu prefixul `/api`. Câteva rute reprezentative:

| Metodă | Rută | Descriere | Acces |
|--------|------|-----------|-------|
| `POST` | `/api/auth/register` | Înregistrare | public |
| `POST` | `/api/auth/login` | Autentificare | public (rate-limited) |
| `GET`  | `/api/gifts/recommend` | Recomandări după criterii | public |
| `GET`  | `/api/gifts/{id}` | Detalii cadou | public |
| `GET`  | `/api/gifts/{id}/reviews` | Recenziile unui cadou | public |
| `POST` | `/api/orders` | Plasează comandă | autentificat |
| `POST` | `/api/admin/gifts` | Creează cadou | admin |
| `GET`  | `/api/admin/reports` | Generează raport | admin |
| `POST` | `/api/admin/imports/dummyjson` | Import catalog DummyJSON | admin |

Lista completă: [`api/routes.php`](api/routes.php).

## Documentație

Raportul proiectului — **[Specificarea cerințelor software](public/scholarlyHTML/index.html)** — în format
Scholarly HTML după macheta IEEE SRS: funcționalități esențiale, interacțiunea cu
utilizatorul, cerințe funcționale și non-funcționale, decizii de arhitectură și etapele
dezvoltării.

## Licență

Cod-sursă sub licență liberă. Conținutul respectă termenii Creative Commons.
