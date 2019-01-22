html:
	asciidoctor -n -a toc=left -a icons README.adoc && \
	ln -f -s README.html index.html

pdf:
	asciidoctor-pdf -n -a toc -a icons README.adoc
