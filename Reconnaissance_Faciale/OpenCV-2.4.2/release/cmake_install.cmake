# Install script for directory: /home/jacques/Workspace/current/M1/BDM/bdm-wavebook-2012/Reconnaissance_Faciale/OpenCV-2.4.2

# Set the install prefix
IF(NOT DEFINED CMAKE_INSTALL_PREFIX)
  SET(CMAKE_INSTALL_PREFIX "/home/jacques/Workspace/current/M1/BDM/bdm-wavebook-2012/Reconnaissance_Faciale/OpenCV-2.4.2/release")
ENDIF(NOT DEFINED CMAKE_INSTALL_PREFIX)
STRING(REGEX REPLACE "/$" "" CMAKE_INSTALL_PREFIX "${CMAKE_INSTALL_PREFIX}")

# Set the install configuration name.
IF(NOT DEFINED CMAKE_INSTALL_CONFIG_NAME)
  IF(BUILD_TYPE)
    STRING(REGEX REPLACE "^[^A-Za-z0-9_]+" ""
           CMAKE_INSTALL_CONFIG_NAME "${BUILD_TYPE}")
  ELSE(BUILD_TYPE)
    SET(CMAKE_INSTALL_CONFIG_NAME "RELEASE")
  ENDIF(BUILD_TYPE)
  MESSAGE(STATUS "Install configuration: \"${CMAKE_INSTALL_CONFIG_NAME}\"")
ENDIF(NOT DEFINED CMAKE_INSTALL_CONFIG_NAME)

# Set the component getting installed.
IF(NOT CMAKE_INSTALL_COMPONENT)
  IF(COMPONENT)
    MESSAGE(STATUS "Install component: \"${COMPONENT}\"")
    SET(CMAKE_INSTALL_COMPONENT "${COMPONENT}")
  ELSE(COMPONENT)
    SET(CMAKE_INSTALL_COMPONENT)
  ENDIF(COMPONENT)
ENDIF(NOT CMAKE_INSTALL_COMPONENT)

# Install shared libraries without execute permission?
IF(NOT DEFINED CMAKE_INSTALL_SO_NO_EXE)
  SET(CMAKE_INSTALL_SO_NO_EXE "1")
ENDIF(NOT DEFINED CMAKE_INSTALL_SO_NO_EXE)

IF(NOT CMAKE_INSTALL_COMPONENT OR "${CMAKE_INSTALL_COMPONENT}" STREQUAL "main")
  FILE(INSTALL DESTINATION "${CMAKE_INSTALL_PREFIX}/include/opencv2" TYPE FILE FILES "/home/jacques/Workspace/current/M1/BDM/bdm-wavebook-2012/Reconnaissance_Faciale/OpenCV-2.4.2/release/opencv2/opencv_modules.hpp")
ENDIF(NOT CMAKE_INSTALL_COMPONENT OR "${CMAKE_INSTALL_COMPONENT}" STREQUAL "main")

IF(NOT CMAKE_INSTALL_COMPONENT OR "${CMAKE_INSTALL_COMPONENT}" STREQUAL "Unspecified")
  FILE(INSTALL DESTINATION "${CMAKE_INSTALL_PREFIX}/lib/pkgconfig" TYPE FILE FILES "/home/jacques/Workspace/current/M1/BDM/bdm-wavebook-2012/Reconnaissance_Faciale/OpenCV-2.4.2/release/unix-install/opencv.pc")
ENDIF(NOT CMAKE_INSTALL_COMPONENT OR "${CMAKE_INSTALL_COMPONENT}" STREQUAL "Unspecified")

IF(NOT CMAKE_INSTALL_COMPONENT OR "${CMAKE_INSTALL_COMPONENT}" STREQUAL "Unspecified")
  FILE(INSTALL DESTINATION "${CMAKE_INSTALL_PREFIX}/share/OpenCV" TYPE FILE FILES "/home/jacques/Workspace/current/M1/BDM/bdm-wavebook-2012/Reconnaissance_Faciale/OpenCV-2.4.2/release/unix-install/OpenCVConfig.cmake")
ENDIF(NOT CMAKE_INSTALL_COMPONENT OR "${CMAKE_INSTALL_COMPONENT}" STREQUAL "Unspecified")

IF(NOT CMAKE_INSTALL_COMPONENT OR "${CMAKE_INSTALL_COMPONENT}" STREQUAL "Unspecified")
  FILE(INSTALL DESTINATION "${CMAKE_INSTALL_PREFIX}/share/OpenCV" TYPE FILE FILES "/home/jacques/Workspace/current/M1/BDM/bdm-wavebook-2012/Reconnaissance_Faciale/OpenCV-2.4.2/release/unix-install/OpenCVConfig-version.cmake")
ENDIF(NOT CMAKE_INSTALL_COMPONENT OR "${CMAKE_INSTALL_COMPONENT}" STREQUAL "Unspecified")

IF(NOT CMAKE_INSTALL_LOCAL_ONLY)
  # Include the install script for each subdirectory.
  INCLUDE("/home/jacques/Workspace/current/M1/BDM/bdm-wavebook-2012/Reconnaissance_Faciale/OpenCV-2.4.2/release/3rdparty/libjasper/cmake_install.cmake")
  INCLUDE("/home/jacques/Workspace/current/M1/BDM/bdm-wavebook-2012/Reconnaissance_Faciale/OpenCV-2.4.2/release/include/cmake_install.cmake")
  INCLUDE("/home/jacques/Workspace/current/M1/BDM/bdm-wavebook-2012/Reconnaissance_Faciale/OpenCV-2.4.2/release/modules/cmake_install.cmake")
  INCLUDE("/home/jacques/Workspace/current/M1/BDM/bdm-wavebook-2012/Reconnaissance_Faciale/OpenCV-2.4.2/release/doc/cmake_install.cmake")
  INCLUDE("/home/jacques/Workspace/current/M1/BDM/bdm-wavebook-2012/Reconnaissance_Faciale/OpenCV-2.4.2/release/data/cmake_install.cmake")
  INCLUDE("/home/jacques/Workspace/current/M1/BDM/bdm-wavebook-2012/Reconnaissance_Faciale/OpenCV-2.4.2/release/apps/cmake_install.cmake")
  INCLUDE("/home/jacques/Workspace/current/M1/BDM/bdm-wavebook-2012/Reconnaissance_Faciale/OpenCV-2.4.2/release/samples/cmake_install.cmake")

ENDIF(NOT CMAKE_INSTALL_LOCAL_ONLY)

IF(CMAKE_INSTALL_COMPONENT)
  SET(CMAKE_INSTALL_MANIFEST "install_manifest_${CMAKE_INSTALL_COMPONENT}.txt")
ELSE(CMAKE_INSTALL_COMPONENT)
  SET(CMAKE_INSTALL_MANIFEST "install_manifest.txt")
ENDIF(CMAKE_INSTALL_COMPONENT)

FILE(WRITE "/home/jacques/Workspace/current/M1/BDM/bdm-wavebook-2012/Reconnaissance_Faciale/OpenCV-2.4.2/release/${CMAKE_INSTALL_MANIFEST}" "")
FOREACH(file ${CMAKE_INSTALL_MANIFEST_FILES})
  FILE(APPEND "/home/jacques/Workspace/current/M1/BDM/bdm-wavebook-2012/Reconnaissance_Faciale/OpenCV-2.4.2/release/${CMAKE_INSTALL_MANIFEST}" "${file}\n")
ENDFOREACH(file)
