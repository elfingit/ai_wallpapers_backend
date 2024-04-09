#!/usr/bin/env bash

INPUT_DIR=./app/Http/Controllers/Api
OUTPUT_DIR=./_doc

apidoc -i $INPUT_DIR -o $OUTPUT_DIR
