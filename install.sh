[[ ":$PATH:" == *":$HOME/bin:"* ]] || echo 'export PATH=$PATH:$HOME/bin' >> ~/.bashrc
mkdir -p ~/.ejaaba
cp ejaaba ~/bin/ejaaba
echo 'Authentication for making man page directory'
mkdir -p /usr/local/man/man1
echo 'Authentication for installing man page'
sudo install -g 0 -o 0 -m 0644 ejaaba.1 /usr/local/man/man1/
sudo gzip /usr/local/man/man1/ejaaba.1
