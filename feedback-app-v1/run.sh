#!/usr/bin/bash

docker compose build php && docker compose --profile tunnel up -d
