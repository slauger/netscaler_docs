.DEFAULT_GOAL := all

CONTAINER_NAME=docker.io/asciidoctor/docker-asciidoctor
CONTAINER_TAG=latest

run:
	docker run -it --mount type=bind,source="$(shell pwd)",target=/documents $(CONTAINER_NAME):$(CONTAINER_TAG) /bin/bash

all: html pdf

html:
	asciidoctor -n -a toc=left -a icons README.adoc -o docs/index.html

pdf:
	asciidoctor-pdf -n -a toc -a icons README.adoc -o docs/netscaler-docs.pdf
