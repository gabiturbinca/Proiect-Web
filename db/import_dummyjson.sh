#!/usr/bin/env bash

set -euo pipefail

BASE_URL="${BASE_URL:-https://giw.onrender.com}"
LIMIT="${LIMIT:-100}"     # DummyJSON: 0 = toate (~194)
SKIP="${SKIP:-0}"
COOKIES="$(mktemp)"
trap 'rm -f "$COOKIES"' EXIT

if [[ -z "${ADMIN_USER:-}" || -z "${ADMIN_PASS:-}" ]]; then
    echo "Setează ADMIN_USER și ADMIN_PASS în mediu." >&2
    exit 1
fi

echo "Autentificare ca '$ADMIN_USER'..."
curl -sS -c "$COOKIES" -X POST "$BASE_URL/api/auth/login" \
    -H "Content-Type: application/json" \
    -d "{\"identifier\":\"$ADMIN_USER\",\"password\":\"$ADMIN_PASS\"}" \
    -o /dev/null

# Extrage token-ul CSRF din cookie jar (format Netscape: valoarea e câmpul 7)
CSRF="$(awk '$6=="csrf_token" {print $7}' "$COOKIES")"
if [[ -z "$CSRF" ]]; then
    echo "Nu am găsit csrf_token — autentificarea a eșuat (user/parolă?)." >&2
    exit 1
fi

echo "Import DummyJSON (limit=$LIMIT, skip=$SKIP)..."
curl -sS -b "$COOKIES" -X POST \
    "$BASE_URL/api/admin/imports/dummyjson?limit=$LIMIT&skip=$SKIP" \
    -H "X-CSRF-Token: $CSRF"
echo

