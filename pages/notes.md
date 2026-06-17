# Notes

This page folder is for local testing.

## Remotes in This Repo

- `origin`: https://github.com/mhalim_rhc/experience-dev (private)
- `public-origin`: https://github.com/manuhal/exp-dev

## Quick Publish Workflow

Use this when you want coworkers to preview updates.

```bash
git push public-origin
```

Alternative manual location (upload the pages there):

- https://page.riohondo.edu/ar/

## Git Remote Cheat Sheet

```bash
git remote -v
# Show remote names with fetch/push URLs.

git remote
# List remote names only.

git remote add <name> <url>
# Add a new remote.

git remote get-url <name>
# Show the remote fetch URL.

git remote set-url <name> <url>
# Update the remote URL.

git remote show <name>
# Show details about a specific remote.

git remote remove <name>
# Remove a remote.
```

## Branch Check Commands

```bash
git branch -r
# List remote branches.

git branch -a
# List local + remote branches.

git fetch --all --prune
# Refresh remotes and remove stale tracking refs.
```