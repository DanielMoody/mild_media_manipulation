# Mild Media Manipulation

Mild Media Manipulation is a lightweight Drupal text filter that allows editors to apply simple layout styles to embedded media using inline tokens.

It wraps content in semantic containers (`<div>` or `<figure>`) and applies predefined CSS classes, optionally including captions.

---
## Installation
Install via Composer:

`composer require cms-alchemy/mild-media-manipulation`

## Features

- Token-based syntax for inline layout control
- Controlled vocabulary (no arbitrary class injection)
- Optional captions using semantic `<figure>` / `<figcaption>`
- Automatically attaches required CSS
- Works inside standard text formats (e.g., Basic HTML, Full HTML)

---

## Concept

Instead of forcing editors to manually write HTML or rely on complex media configuration, this module provides a simple wrapper syntax:


[mmm:variant] ... [/mmm]


This allows layout decisions to remain **editor-controlled but constrained**, avoiding layout chaos.

---

## 🧾 Usage

### Basic syntax


[mmm:left-side]
<img src="/example.jpg" />
[/mmm]


### With caption


[mmm:right-side]
<img src="/example.jpg" /> | This is a caption
[/mmm]


---

## Available Variants

- `left-side` → floats content left
- `right-side` → floats content right
- `two-column` → grid layout (2 columns)
- `centered` → centered content

Invalid variants are ignored (content passes through unchanged).

---

##  Output Behavior

### Without caption

<div class="mmm mmm--left-side"> ... </div> ```
With caption
<figure class="mmm mmm--left-side">
  ...
  <figcaption class="mmm__caption">...</figcaption>
</figure>
