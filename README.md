# Super Awesome Theme (Boilerplate)

This is the boilerplate for Taco Themes.

## Getting Started

To create your own theme, download this repository. For the next steps, let's assume your theme should be called `Taco World`.

1. Rename the directory to `taco-world`.
2. Open `gulpfile.js` and scroll to the bottom.
3. Replace every value in the `replacements` object with your new theme name in the appropriate format. For example, replace `my-new-theme-name` with `taco-world`, `MY_NEW_THEME_NAME` with `TACO_WORLD` and so on.
4. Save the changes.
5. Check the `package.json` file. You might wanna update some details to your preferences.
6. Run `npm install` in the console.
7. Run `gulp init-replace` in the console.
8. Open `gulpfile.js` again and remove the entire bottom section that starts with `INITIAL SETUP TASK`, save the file afterwards.
9. Run `gulp build` once to compile everything.

Now you're good to go!

TODO: codeclimate.yml
