# CMAKE generated file: DO NOT EDIT!
# Generated by "Unix Makefiles" Generator, CMake Version 2.8

#=============================================================================
# Special targets provided by cmake.

# Disable implicit rules so canonical targets will work.
.SUFFIXES:

# Remove some rules from gmake that .SUFFIXES does not remove.
SUFFIXES =

.SUFFIXES: .hpux_make_needs_suffix_list

# Suppress display of executed commands.
$(VERBOSE).SILENT:

# A target that is always out of date.
cmake_force:
.PHONY : cmake_force

#=============================================================================
# Set environment variables for the build.

# The shell in which to execute make rules.
SHELL = /bin/sh

# The CMake executable.
CMAKE_COMMAND = /usr/bin/cmake

# The command to remove a file.
RM = /usr/bin/cmake -E remove -f

# The top-level source directory on which CMake was run.
CMAKE_SOURCE_DIR = /home/jacques/Workspace/current/M1/BDM/bdm-wavebook-2012/Reconnaissance_Faciale/OpenCV-2.4.2

# The top-level build directory on which CMake was run.
CMAKE_BINARY_DIR = /home/jacques/Workspace/current/M1/BDM/bdm-wavebook-2012/Reconnaissance_Faciale/OpenCV-2.4.2/release

# Include any dependencies generated for this target.
include samples/c/CMakeFiles/example_latentsvmdetect.dir/depend.make

# Include the progress variables for this target.
include samples/c/CMakeFiles/example_latentsvmdetect.dir/progress.make

# Include the compile flags for this target's objects.
include samples/c/CMakeFiles/example_latentsvmdetect.dir/flags.make

samples/c/CMakeFiles/example_latentsvmdetect.dir/latentsvmdetect.cpp.o: samples/c/CMakeFiles/example_latentsvmdetect.dir/flags.make
samples/c/CMakeFiles/example_latentsvmdetect.dir/latentsvmdetect.cpp.o: ../samples/c/latentsvmdetect.cpp
	$(CMAKE_COMMAND) -E cmake_progress_report /home/jacques/Workspace/current/M1/BDM/bdm-wavebook-2012/Reconnaissance_Faciale/OpenCV-2.4.2/release/CMakeFiles $(CMAKE_PROGRESS_1)
	@$(CMAKE_COMMAND) -E cmake_echo_color --switch=$(COLOR) --green "Building CXX object samples/c/CMakeFiles/example_latentsvmdetect.dir/latentsvmdetect.cpp.o"
	cd /home/jacques/Workspace/current/M1/BDM/bdm-wavebook-2012/Reconnaissance_Faciale/OpenCV-2.4.2/release/samples/c && /usr/bin/c++   $(CXX_DEFINES) $(CXX_FLAGS) -o CMakeFiles/example_latentsvmdetect.dir/latentsvmdetect.cpp.o -c /home/jacques/Workspace/current/M1/BDM/bdm-wavebook-2012/Reconnaissance_Faciale/OpenCV-2.4.2/samples/c/latentsvmdetect.cpp

samples/c/CMakeFiles/example_latentsvmdetect.dir/latentsvmdetect.cpp.i: cmake_force
	@$(CMAKE_COMMAND) -E cmake_echo_color --switch=$(COLOR) --green "Preprocessing CXX source to CMakeFiles/example_latentsvmdetect.dir/latentsvmdetect.cpp.i"
	cd /home/jacques/Workspace/current/M1/BDM/bdm-wavebook-2012/Reconnaissance_Faciale/OpenCV-2.4.2/release/samples/c && /usr/bin/c++  $(CXX_DEFINES) $(CXX_FLAGS) -E /home/jacques/Workspace/current/M1/BDM/bdm-wavebook-2012/Reconnaissance_Faciale/OpenCV-2.4.2/samples/c/latentsvmdetect.cpp > CMakeFiles/example_latentsvmdetect.dir/latentsvmdetect.cpp.i

samples/c/CMakeFiles/example_latentsvmdetect.dir/latentsvmdetect.cpp.s: cmake_force
	@$(CMAKE_COMMAND) -E cmake_echo_color --switch=$(COLOR) --green "Compiling CXX source to assembly CMakeFiles/example_latentsvmdetect.dir/latentsvmdetect.cpp.s"
	cd /home/jacques/Workspace/current/M1/BDM/bdm-wavebook-2012/Reconnaissance_Faciale/OpenCV-2.4.2/release/samples/c && /usr/bin/c++  $(CXX_DEFINES) $(CXX_FLAGS) -S /home/jacques/Workspace/current/M1/BDM/bdm-wavebook-2012/Reconnaissance_Faciale/OpenCV-2.4.2/samples/c/latentsvmdetect.cpp -o CMakeFiles/example_latentsvmdetect.dir/latentsvmdetect.cpp.s

samples/c/CMakeFiles/example_latentsvmdetect.dir/latentsvmdetect.cpp.o.requires:
.PHONY : samples/c/CMakeFiles/example_latentsvmdetect.dir/latentsvmdetect.cpp.o.requires

samples/c/CMakeFiles/example_latentsvmdetect.dir/latentsvmdetect.cpp.o.provides: samples/c/CMakeFiles/example_latentsvmdetect.dir/latentsvmdetect.cpp.o.requires
	$(MAKE) -f samples/c/CMakeFiles/example_latentsvmdetect.dir/build.make samples/c/CMakeFiles/example_latentsvmdetect.dir/latentsvmdetect.cpp.o.provides.build
.PHONY : samples/c/CMakeFiles/example_latentsvmdetect.dir/latentsvmdetect.cpp.o.provides

samples/c/CMakeFiles/example_latentsvmdetect.dir/latentsvmdetect.cpp.o.provides.build: samples/c/CMakeFiles/example_latentsvmdetect.dir/latentsvmdetect.cpp.o

# Object files for target example_latentsvmdetect
example_latentsvmdetect_OBJECTS = \
"CMakeFiles/example_latentsvmdetect.dir/latentsvmdetect.cpp.o"

# External object files for target example_latentsvmdetect
example_latentsvmdetect_EXTERNAL_OBJECTS =

bin/latentsvmdetect: samples/c/CMakeFiles/example_latentsvmdetect.dir/latentsvmdetect.cpp.o
bin/latentsvmdetect: lib/libopencv_core.so.2.4.2
bin/latentsvmdetect: lib/libopencv_flann.so.2.4.2
bin/latentsvmdetect: lib/libopencv_imgproc.so.2.4.2
bin/latentsvmdetect: lib/libopencv_highgui.so.2.4.2
bin/latentsvmdetect: lib/libopencv_ml.so.2.4.2
bin/latentsvmdetect: lib/libopencv_video.so.2.4.2
bin/latentsvmdetect: lib/libopencv_objdetect.so.2.4.2
bin/latentsvmdetect: lib/libopencv_photo.so.2.4.2
bin/latentsvmdetect: lib/libopencv_nonfree.so.2.4.2
bin/latentsvmdetect: lib/libopencv_features2d.so.2.4.2
bin/latentsvmdetect: lib/libopencv_calib3d.so.2.4.2
bin/latentsvmdetect: lib/libopencv_legacy.so.2.4.2
bin/latentsvmdetect: lib/libopencv_contrib.so.2.4.2
bin/latentsvmdetect: lib/libopencv_ml.so.2.4.2
bin/latentsvmdetect: lib/libopencv_video.so.2.4.2
bin/latentsvmdetect: lib/libopencv_objdetect.so.2.4.2
bin/latentsvmdetect: lib/libopencv_calib3d.so.2.4.2
bin/latentsvmdetect: lib/libopencv_features2d.so.2.4.2
bin/latentsvmdetect: lib/libopencv_flann.so.2.4.2
bin/latentsvmdetect: lib/libopencv_highgui.so.2.4.2
bin/latentsvmdetect: lib/libopencv_imgproc.so.2.4.2
bin/latentsvmdetect: lib/libopencv_core.so.2.4.2
bin/latentsvmdetect: /usr/lib/i386-linux-gnu/libz.so
bin/latentsvmdetect: samples/c/CMakeFiles/example_latentsvmdetect.dir/build.make
bin/latentsvmdetect: samples/c/CMakeFiles/example_latentsvmdetect.dir/link.txt
	@$(CMAKE_COMMAND) -E cmake_echo_color --switch=$(COLOR) --red --bold "Linking CXX executable ../../bin/latentsvmdetect"
	cd /home/jacques/Workspace/current/M1/BDM/bdm-wavebook-2012/Reconnaissance_Faciale/OpenCV-2.4.2/release/samples/c && $(CMAKE_COMMAND) -E cmake_link_script CMakeFiles/example_latentsvmdetect.dir/link.txt --verbose=$(VERBOSE)

# Rule to build all files generated by this target.
samples/c/CMakeFiles/example_latentsvmdetect.dir/build: bin/latentsvmdetect
.PHONY : samples/c/CMakeFiles/example_latentsvmdetect.dir/build

samples/c/CMakeFiles/example_latentsvmdetect.dir/requires: samples/c/CMakeFiles/example_latentsvmdetect.dir/latentsvmdetect.cpp.o.requires
.PHONY : samples/c/CMakeFiles/example_latentsvmdetect.dir/requires

samples/c/CMakeFiles/example_latentsvmdetect.dir/clean:
	cd /home/jacques/Workspace/current/M1/BDM/bdm-wavebook-2012/Reconnaissance_Faciale/OpenCV-2.4.2/release/samples/c && $(CMAKE_COMMAND) -P CMakeFiles/example_latentsvmdetect.dir/cmake_clean.cmake
.PHONY : samples/c/CMakeFiles/example_latentsvmdetect.dir/clean

samples/c/CMakeFiles/example_latentsvmdetect.dir/depend:
	cd /home/jacques/Workspace/current/M1/BDM/bdm-wavebook-2012/Reconnaissance_Faciale/OpenCV-2.4.2/release && $(CMAKE_COMMAND) -E cmake_depends "Unix Makefiles" /home/jacques/Workspace/current/M1/BDM/bdm-wavebook-2012/Reconnaissance_Faciale/OpenCV-2.4.2 /home/jacques/Workspace/current/M1/BDM/bdm-wavebook-2012/Reconnaissance_Faciale/OpenCV-2.4.2/samples/c /home/jacques/Workspace/current/M1/BDM/bdm-wavebook-2012/Reconnaissance_Faciale/OpenCV-2.4.2/release /home/jacques/Workspace/current/M1/BDM/bdm-wavebook-2012/Reconnaissance_Faciale/OpenCV-2.4.2/release/samples/c /home/jacques/Workspace/current/M1/BDM/bdm-wavebook-2012/Reconnaissance_Faciale/OpenCV-2.4.2/release/samples/c/CMakeFiles/example_latentsvmdetect.dir/DependInfo.cmake --color=$(COLOR)
.PHONY : samples/c/CMakeFiles/example_latentsvmdetect.dir/depend
