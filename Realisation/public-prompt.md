# ✅ **Prompt – Generate Public Section of the Blog (Laravel + Tailwind)**

Generate the **public section** of a blog using **Laravel**, **Blade**, and **TailwindCSS**.
This is the **frontend** visible to visitors.

---

# 🎯 **Context**

The backend (admin module) already exists with:

* Articles managed from `/admin/articles`
* ArticleService to prepare data
* Models: `Article`, `Category`, `User`
* Article ↔ Category (many-to-many)
* Article ↔ User (many-to-one)
* Articles have:

  * title
  * HTML content (from Summernote)
  * categories
  * author
  * status (Draft / Published)
  * timestamps

👉 Public must show only **published** articles.

---

# 🛠️ **Your Task**

Generate a complete **public UI** with:

---

## ✔️ **1. Public Routes**

Generate Laravel routes:

* GET `/` → Home (latest articles)
* GET `/articles` → Article list
* GET `/articles/{slug}` → Article detail page
* GET `/categories/{slug}` → Articles by category
* Optional: search route `/search`

All must use `ArticleService` for reading.

---

## ✔️ **2. Public Controller: `Public/BlogController`**

Methods to implement:

* `index()` → return last 6 published articles
* `articles()` → paginated list of published articles
* `category($slug)` → list filtered by category
* `show($slug)` → display one article with its HTML content
* `search()` → articles matching search keywords

**No business logic** → all calls go to ArticleService.

---

## ✔️ **3. Service Layer Additions (ArticleService)**

Public reading methods:

* `getPublishedArticles($filters = [])`
* `getArticleBySlug($slug)`
* `getArticlesByCategory($slug)`
* `searchArticles($keyword)`

Each method must:

* Filter only articles where `status = 'published'`
* Include categories + author
* Return paginated results where necessary
* Order by newest first

---

## ✔️ **4. Blade Views (TailwindCSS)**

Generate the following:

---

### **a. `/resources/views/public/home.blade.php`**

* Hero header
* Grid of latest 6 articles
* Each card includes:

  * Title
  * Short excerpt
  * Category badges
  * “Read more” link

---

### **b. `/resources/views/public/articles.blade.php`**

A full list of articles with:

* Search bar
* Category filter (links or dropdown)
* Pagination (Tailwind style)
* Article cards with:

  * Title
  * Small excerpt
  * Publish date
  * Category badges
  * Read More button

---

### **c. `/resources/views/public/show.blade.php`**

Article detail page:

* Title
* Author’s name + date
* Category badges
* Full HTML content (show using `{!! $article->content !!}`)
* Related articles section (optional)

---

### **d. `/resources/views/public/category.blade.php`**

* Show category title
* List of articles in that category (paginated)

---

## ✔️ **5. Styling Requirements**

Use only **TailwindCSS**:

* container with `mx-auto` + `max-w-6xl`
* responsive grid: `grid grid-cols-1 md:grid-cols-3 gap-6`
* category badges:
  `inline-block bg-blue-100 text-blue-600 font-medium px-2 py-1 rounded`

---

## ✔️ **6. Extra Functionalities**

Include:

### **🔍 Search bar**

* input for keyword
* filter results using ArticleService
* show “No results found” if empty

### **📂 Categories in sidebar**

* List all categories
* Show number of articles per category

### **📄 Pagination**

* Use Tailwind pagination styles
* Ordered newest to oldest

---

## ✔️ **7. Output Format**

Deliver:

* Routes
* Controller code
* Service methods
* All Blade files (Tailwind)
* Example queries
* Pagination UI
* Search feature
* Category filter UI

---

# 🔥 Expected Result

A complete, beautiful, responsive **public section** for the blog with:

* Home page
* Article list
* Article details
* Category pages
* Search
* Pagination
* Tailwind UI
* Clean architecture via Service Layer

---